<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{

	public function index()
	{
		return view('suppliers.suppliersHome');
	}


	public function store(Request $request, $id = 0)
	{
		if ($id != 0) {
			$supplier = Supplier::findOrFail($id);
			$text = "Supplier Details has been successfully changed!";
		} else {
			$supplier = new Supplier();
			$this->validate(request(), ["name" => "required|min:1"]);
			$text = "Successfully Added a new Supplier!";
		}

		$supplier->name = request('name');
		$supplier->address = request('address');
		$supplier->mobile = request('mobile');

		$supplier->save();

		Session::flash('message', $text);
		return redirect('/suppliers');
	}
	public function edit($id)
	{
		$supplier = Supplier::find($id);
		return view('suppliers.updateSupplier', compact('supplier'));
	}
}
