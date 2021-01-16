<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{

	public function index()
	{
		$suppliers = Supplier::paginate(15);
		return view('suppliers.suppliersHome', compact('suppliers'));
	}


	public function store(Request $request, $id = 0)
	{
		if ($id != 0) {
			$supplier = Supplier::findOrFail($id);
			$text = "فرۆشیارەکە تازەکرایەوە بەسەرکەوتوویی";
		} else {
			$supplier = new Supplier();
			$this->validate(request(), ["name" => "required|min:1"]);
			$text = "فرۆشیارەکە بەسەرکەوتووی زیاد کرا";
		}

		$supplier->name = request('name');
		$supplier->address = request('address');
		$supplier->mobile = request('mobile');
		$supplier->isDollar = request('isDollar');

		$supplier->save();

		Session::flash('message', $text);
		return redirect('/suppliers');
	}
	public function edit($id)
	{
		$supplier = Supplier::find($id);
		return view('suppliers.updateSupplier', compact('supplier'));
	}
	public function search()
	{
		$id = request('id');
		$suppliers = Supplier::whereId($id)->paginate(1);
		return view('suppliers.suppliersHome', compact('suppliers'));
	}
}
