<?php

namespace App\Http\Controllers;

use \App\Item;
use \App\Sale;
use Illuminate\Http\Request;
use App\Events\SaleCreatedEvent;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
  public function index()
  {
    return view('sales.addSale');
  }
  public function seeSales($id = 0)
  {
    if ($id == 0) {
      $sales = Sale::with(['items', 'user'])->latest()->paginate(15);
    } else {
      $sales = Sale::with('items')->where('id', $id)->paginate(1);
    }
    return view('sales.seeSales', compact('sales'));
  }

  public function viewReturned()
  {
    $sales = Sale::where('type', 'returned_sale')->latest()->paginate(25);
    return view('sales.seeSales', compact('sales'));
  }

  public function create(Request $request, $id = 0)
  {

    $this->validate($request, [
      'total' => 'required|gte:0',
      'discount' => 'lte:total',
    ]);

    if ($id == 0) {
      $sale = new Sale();
      $sale->rate = $request['rate'];
      $sale->user_id = auth()->user()->id;
      $sale->status = 1;
    } else {
      $sale = Sale::find($id);
      $sale->items()->detach();
      DB::table('stocks')->where('type', $sale->type)->where('source_id', $sale->id)->delete();
      $sale->items()->detach();
    }

    $howManyItems = $request['howManyItems'];
    $sale->type = $request['type'];
    $sale->description = $request['description'];
    $sale->discount = $request['discount'];
    $sale->dinars = $request['total'];
    $sale->dollars = 0;
    $sale->total = $request['total'] - $request['discount'];
    $sale->calculatedPaid = $sale->total;


    $sale->save();
    $sale->addItems($request['item']);

    event(new SaleCreatedEVent($sale));

    if (isset($request['save-print'])) {
      return redirect(route('print-sale', $sale->id));
    } elseif (isset($request['save'])) {
      session()->flash('message', 'Successful');
      return redirect(route('add-sale'));
    }
  }

  public function destroy($id)
  {
    $sale = Sale::findOrFail($id);

    DB::table('sale_items')->where('sale_id', $sale->id)->delete();
    Sale::destroy($id);
    DB::table('stocks')->where('type', $sale->type)->where('source_id', $id)->delete();

    return redirect('/sale/seeSales');
  }
  public function salePrint($id)
  {
    $sale = Sale::with('items')->find($id);
    return view('sales.salePrint', compact(['sale']));
  }

  public function searchByItem(Request $request)
  {
    $barcode = $request['barcode'];
    if (empty($barcode))
      return redirect('/sale/seeSales');
    $sales = Sale::whereHas('items', function ($query) use ($barcode) {
      $query->where('barcode', $barcode);
    })->paginate(25);
    return view('sales.seeSales', compact('sales'));
  }


  public function search()
  {
    $id = Request('sale_id');
    return redirect('/sale/seeSales/' . $id);
  }

  public function edit($id)
  {
    $sale = Sale::find($id);
    return view('sales.updateSale', compact('sale'));
  }
}
