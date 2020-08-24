<?php

namespace App\Http\Controllers;

use DB;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\PurchaseCreatedEvent;

class PurchaseController extends Controller
{
	public function index($id = 0)
	{
		if ($id == 0)
			$purchases = Purchase::latest()->paginate(25);
		else
			$purchases = Purchase::where('id', $id)->paginate(1);

		return view('purchases.seePurchase', compact('purchases'));
	}

	public function viewReturned()
	{
		$purchases = Purchase::where('type', 'returned_purchase')->latest()->paginate(25);
		return view('purchases.seePurchase', compact('purchases'));
	}


	public function add()
	{
		return view('purchases.addPurchase');
	}
	public function store(Request $request, $id = 0)
	{
		$this->validate($request, [
			'total' => 'required|gt:0',
			'invoice_no' => 'required',
			'supplier_id' => 'required|exists:suppliers,id',
			'type' => 'required',
			'barcode' => 'required|array|min:1',
			'quantity' => 'required|array|min:1',
			'quantity.*' => 'required|gte:0',
			'sppi' => 'required|array|min:1',
			'bonus' => 'required|array|min:1',
			'ppi' => 'required|array|min:1',
			'ppi.*' => 'required|gte:0',
			'exp' => 'required|array|min:1',
			'exp.*' => 'required|date',
		]);
		if ($id !== 0) {
			$purchase = Purchase::findOrFail($id);
			$purchase->items()->detach();
			DB::table('stocks')->where('type', $purchase->type)->where('source_id', $purchase->id)->delete();
		} else {
			$purchase = new Purchase();
			$purchase->user_id = \Auth::user()->id;
		}

		$purchase->supplier_id = $request['supplier_id'];
		$purchase->invoice_no = $request['invoice_no'];
		$purchase->total = $request['total'];
		$purchase->type = $request['type'];
		$purchase->save();
		$barcode = $request['barcode'];
		foreach ($barcode as $key => $barcode) {
			$barcode = $barcode;
			$item = \App\Item::find($barcode);
			$item->sale_price_id = $request['sppi'][$key];
			$item->purchase_price = $request['ppi'][$key];
			$item->save();
			$quantity = $request['quantity'][$key];
			$ppi = $request['ppi'][$key];
			$exp = $request['exp'][$key];
			$bonus = $request['bonus'][$key];
			$batch_no = $request['batch_no'][$key];

			if ($barcode === 0 ||  ($quantity === 0 && $bonus === 0)) {
				continue;
			}
			$purchase->items()->attach($barcode, ['ppi' => $ppi, 'quantity' => $quantity, 'bonus' => $bonus, 'exp' => $exp, 'batch_no' => $batch_no]);
		}
		event(new PurchaseCreatedEvent($purchase));
		return redirect('/purchase/see/' . $purchase->id);
	}

	public function edit($id)
	{
		$purchase = Purchase::find($id);
		return view('purchases.updatePurchase', compact('purchase'));
	}

	public function search(Request $request)
	{
		$id = $request['purchase_id'];
		$from = $request['start_date'];
		$to = $request['end_date'];
		$supplier_id = $request['supplier_id'];

		$query = Purchase::query();

		if (!empty($id))
			$query->where('invoice_no', '=', $id);

		if (!empty($from))
			$query->whereDate('created_at', '>=', $from);


		if (!empty($to))
			$query->whereDate('created_at', '<=', $to);
		if ($supplier_id != '-1')
			$query->where('supplier_id', $supplier_id);

		$purchases = $query->paginate(20);
		return view('purchases.purchaseReports', compact('purchases'));
	}

	public function searchByItem(Request $request)
	{
		$barcode = $request['barcode'];

		if (empty($barcode))
			return redirect('/purchase/see');


		$purchases = Purchase::whereHas('items', function ($query) use ($barcode) {
			$query->where('barcode', $barcode);
		})->paginate(25);
		return view('purchases.seePurchase', compact('purchases'));
	}

	public function delete($id)
	{
		$purchase = Purchase::findOrFail($id);
		DB::table('purchase_items')->where('purchase_id', $id)->delete();
		Purchase::destroy($id);
		DB::table('stocks')->where('type', $purchase->type)->where('source_id', $id)->delete();

		\Session::flash('message', 'Successfuly Deleted');
		\Session::flash('type', 'success');
		return redirect('/purchase/see');
	}
	public function showSupplierPurchases($id)
	{
		$purchases = Purchase::with('items')->where('supplier_id', $id)->latest()->paginate(20);
		return view('purchases.seePurchase', compact('purchases'));
	}
}
