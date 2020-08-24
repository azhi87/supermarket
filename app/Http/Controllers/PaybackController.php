<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class PaybackController extends Controller
{
	public function index($id)
	{
		$supplier = Supplier::with('paybacks')->where('id', $id)->first();
		return view('paybacks.payback', compact('supplier'));
	}
	public function store(Request $request, $id = 0)
	{
		$this->validate($request, [
			'paid' => 'required|numeric',
			'discount' => 'required|numeric'
		]);

		if ($id == 0) {
			$payback = new \App\Payback();

			$result = 'Payment was Successfully stored';
		} else {
			$payback = \App\Payback::find($id);
			$result = 'Changes were successfully made';
		}
		$payback->supplier_id = $request['supplier_id'];
		$payback->user_id = \Auth::user()->id;
		$payback->paid = $request['paid'];
		$payback->discount = $request['discount'];
		$payback->description = $request['description'];
		$payback->currency = '$';
		$payback->save();
		\Session::flash('message', $result);
		return redirect('/paybacks/' . $payback->supplier_id);
	}
	public function edit($id)
	{
		$payback = \App\Payback::find($id);
		return view('paybacks.updatePayback', compact('payback'));
	}

	public function printing($id)
	{
		$payback = \App\Payback::find($id);
		return view('paybacks.printPayback', compact('payback'));
	}
}
