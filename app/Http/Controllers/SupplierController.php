<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Supplier;
class SupplierController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
		if(\Auth::check())
		{
    		return $next($request);
    	}
    	else
    	{
    		return redirect('/login');
    	}
});
	}
    public function index()
    {
    	
    	return view('suppliers.suppliersHome');
    }
    public function search()
    {
    	$id=request('id');
	   	$searchSuppliers=Supplier::find($id);
	   	if(count($searchSuppliers))
	   	$searchSuppliers=array($searchSuppliers);
	   	return view('suppliers.suppliersHome',compact('searchSuppliers'));
    }
    public function store(Request $request,$id=0)
    {
	     if($id!=0)
	   	 {
	   	 	$supplier=Supplier::find($id);
	   	 	$text="گۆڕانکاریەکە بەسەرکەوتوویی تۆمارکرا کرا";
	   	 }
	   	 else
	   	 {
	   	 	$supplier=new Supplier;
	   	 	 $this->validate(request(),
	   		[
		   	 	"name"=>"required|min:1",
		   	 	"id"=>"unique:suppliers",
	   		]);
	   	 	 if($request->has('id'))
	  		{
	  			$supplier->id=request('id');
	  		}
	  		$text="کۆمپانیاکە بەسەرکەوتوویی زیاد کرا";
	   	 }
	   	
	  		
	   		$supplier->name=request('name');
			$supplier->address=request('address');
			$supplier->mobile=request('mobile');
			
		    $supplier->save();
		    
   			\Session::flash('message', $text);
		    return redirect('/suppliers');
	}
	public function edit($id)
   {
   	$supplier=Supplier::find($id);
   	return view('suppliers.updateSupplier',compact('supplier'));
   }
}
