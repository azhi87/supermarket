<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
	    
Route::get('/', function () {
	$users=\App\User::where('status','1')->get();
    return view('main.index',compact('users'));
});



Route::get('/users/edit/{id}','UserController@edit')->name('edit-user');
Route::post('/users/update/{id}','UserController@updateUser')->name('update-user');
Route::get('/users','UserController@showUsers');
Route::get('/users/toggle/{id}','UserController@toggleUser');
Route::get('/home', 'HomeController@index')->name('home');


	Route::get('/items/add','ItemController@create');
	Route::get('/items/edit/{id}','ItemController@edit');
	Route::post('/items/update/{id}','ItemController@store');
	Route::post('/cats/add','ItemController@addCategory');
	Route::post('/items/search','ItemController@search');
	Route::post('/items/searchName','ItemController@searchName');
	Route::post('/items/store','ItemController@store');

	Route::get('/sale/delete/{id}','SaleController@destroy');
	Route::get('/suppliers','SupplierController@index');
	Route::post('/suppliers/search','SupplierController@search');
	Route::post('/suppliers/store/{id?}','SupplierController@store');
	Route::get('/suppliers/edit/{id}','SupplierController@edit');

	Route::get('reports/stockValuation','ReportController@stockValuation');
	Route::post('/category/edit/{id}','CategoryController@update');
      

	Route::post('/stock/expiry','StockController@stockExpiry');
	Route::get('/sale/ok/{id}','SaleController@ok');

Route::get('/reports/stock','ReportController@showStock')->name('show-stock');
Route::post('/reports/supplierDebt','ReportController@supplierDebt')->name('supplier-debt-report');

Route::post('/stock','ReportController@stockByCategory')->name('show-stock-by-cat');
Route::post('/stock/stockByItem','ReportController@stockByItem')->name('show-item-stock');
		

		
	Route::post('/sale/search','SearchController@searchSale');
	Route::post('/sale/searchId','SaleController@search');
	
    Route::get('/sale/edit/{index}','SaleController@edit');
	
	Route::post('/sale/mandwbTotalByDate','SaleController@mandwbTotalByDate');
	
	Route::get('/purchases/ItemPrice','ItemController@getItemPrice');
	Route::get('/purchase/getExpiryDates','ItemController@getExpiryDate');
	Route::get('/purchases/ItemPurchasePrice','ItemController@getItemPurchasePrice');

	

	Route::get('/sales/addSale','SaleController@index');
	Route::post('/sale/create/{id?}','SaleController@create');
	Route::get('/sale/seeSales/{id?}','SaleController@seeSales')->name('show-sales');
	Route::get('/sale/print/{index}','SaleController@salePrint');
	Route::post('/sale/update/{id}','SaleController@store');

	Route::view('/sale/home','sales.saleHome');
	Route::view('sale/search','sales.searchSale');
	Route::get('/logout',function(){
		\Auth::logout();
		return redirect('/login');
		});
	
	Route::post('/sale/searchByItem','SaleController@searchByItem')->name('search-sale-byItem');
	Route::get('/sale/viewReturned','SaleController@viewReturned')->name('view-returned-sales');

	
	Route::view('/purchases/add','purchases.addPurchase');   	
	Route::post('/purchase/create/{id?}','PurchaseController@store')->name('store-purchase');
	Route::get('purchase/see/{id?}','PurchaseController@index')->name('show-purchases');
	Route::get('purchase/viewReturned/{id?}','PurchaseController@viewReturned')->name('view-returned-purchases');
	Route::get('/purchase/search','PurchaseController@search')->name('search-purchase');
	Route::post('/purchase/searchByItem','PurchaseController@searchByItem')->name('search-purchase-byItem');
	Route::post('/purchase/search','PurchaseController@search');
	Route::get('/purchase/delete/{id}','PurchaseController@delete');
	Route::get('/purchase/edit/{id}','PurchaseController@edit');
	Route::post('/purchase/update/{id}','PurchaseController@update');



	Route::get('/expenses','ExpenseController@index');
	Route::post('/expenses/store/{id}','ExpenseController@store');
	Route::post('/expenses/store/','ExpenseController@store');
	Route::post('/expenses/search','ExpenseController@search');
	Route::post('/expenses/searchReason','ExpenseController@searchReason');
		
		Route::get('/expenses/edit/{id}',function($id){
			$expense=\App\Expense::find($id);
			return view('expenses.expenseUpdate',compact('expense'));
		});


	Route::post('/reports/supplierSale',function(){
			$to=Request('to');
			$from=Request('from');
			$items=\App\Item::notDeleted()->where('supplier_id',Request('supplier_id'))->get();
			$name=\App\Supplier::find(Request('supplier_id'))->name;
			return view('reports.supplierSale',compact(['items','from','to','name']));
			});


	Route::post('/reports/salesByDate','SaleController@salesByDate');

	Route::post('/reports/mandwb','ItemController@mandwbReports');
	Route::post('/reports/mandwbSales','SaleController@mandwbSaleReport');
	Route::post('/reports/income','ReportController@income')->name('income-money');
	Route::post('/reports/returnedItems','ReturnController@report');
	Route::post('/reports/monthlyMandwb',function(){
			$user_id=Request('user_id');
			$to=Request('to');
			$from=Request('from');
			$user=\App\User::find($user_id);
			$sales=$user->sales()->where('status','1')->whereDate('created_at','>=',$from)
                          ->whereDate('created_at','<=',$to)->get();
			$user=$user->name;
			return view('reports.monthlyMandwb',compact(['from','to','sales','user']));
	});

	Route::get('/reports',function(){
		return view('reports.reportHome');
	});
	
	Route::livewire('/live-items','add-item')->layout('layouts.master')->name('add-item');
	Route::livewire('/show-items','show-item')->layout('layouts.master')->name('show-items');
	Route::livewire('/show-popular-items','item-popularity')->layout('layouts.master')->name('show-popular-items');
	Route::livewire('/item/transactions/{id?}','item-transactions')->layout('layouts.master')->name('show-item-transactions');
	
		Route::get('/peripheralUpdates',function(){
		return view('items.peripheralUpdates');
	});
	
	
	Route::post('/rate/add','RateController@create');
	Route::post('/rate',function(){
			$rate=new \App\Rate;
			$rate->rate=Request('rate');
			$rate->user_id=\Auth::user()->id;
			$rate->save();
			return redirect('/');
	});
	
	
	Route::post('/drugs/searchAjax',function(){
 $search = request()->search;

      if($search == '')
      {
         $items = \App\Item::orderby('name','asc')->select('id','name')->limit(0)->get();
      }
      else
      {
         $items = \App\Item::where(function ($q) use ($search) {
						 $q->where('name', 'like', '%' .$search . '%')
						 ->orWhere('barcode', 'like', '%' .$search . '%');
            }
            )->limit(5)->get();
       }

      $response = array();
      foreach($items as $item){
         $response[] = array(
              "id"=>$item->id,
              "text"=>$item->name
         );
      }

      echo json_encode($response);
      exit;
});
	
});
	
	


