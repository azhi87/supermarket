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

Route::get('/test', function () {
    return view('main.test');
});

Route::get('/users/edit/{id}',function($id){
	$user=\App\User::find($id);
	return view('auth.updateUser',compact('user'));
	});
Route::post('/users/update/{id}','UserController@updateUser');
Route::get('/users',function(){
	$users=\App\User::all();
	return view('auth.showUsers',compact('users'));
});

Route::get('/users/toggle/{id}',function($id){
	$user=\App\User::find($id);
	$user->toggleStatus();
	 return redirect('/users');
			});



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

	Route::get('reports/stockValuation',function(){
		$items=\App\Item::notDeleted()->get();
		return view('reports.stockValuation',compact('items'));
	});
	
	Route::post('/category/edit/{id}',function($id){
        $cat=\App\Category::find($id);
        $cat->category=Request('category');
        $cat->save();
        return redirect('/live-items')->withMessage('Category name was successfuly Update');
        
    	});


	Route::post('/stock/expiry','StockController@stockExpiry');
	Route::get('/sale/ok/{id}','SaleController@ok');

Route::get('/reports/stock',function(){
			$items=\App\Item::notDeleted()->get();
			return view('reports.stock',compact('items'));
		})->middleware('auth');

Route::post('/stock',function(){
			$cat=Request('cat');
			$items=\App\Item::where('category_id',$cat)->get();
			return view('reports.stock',compact('items'));
		})->middleware('auth');
		

		
	Route::post('/sale/search','SearchController@searchSale');
	Route::post('/sale/searchId','SaleController@search');
	// Route::get('/', 'EventController@index');
	Route::post('/event/store','EventController@store');
	Route::get('/event/delete/{id}', 'EventController@destroy');
    Route::get('/sale/edit/{index}',function($index){
			$sale=\App\Sale::find($index);
			if(\Auth::user()->type=='mandwb' && ($sale->status==1 || $sale->user_id!=\Auth::user()->id))
			{   
			    return back();
			}
			return view('sales.updateSale',compact('sale'));
	});
	Route::get('dayEvents/{day}','EventController@dayEvents');
	
	Route::post('/sale/mandwbTotalByDate','SaleController@mandwbTotalByDate');
	Route::get('/debts/{id?}','DebtController@index');
	Route::get('/debt/print/{id}','DebtController@debtPrint');
	Route::get('/customers/customerNameById','CustomerController@getDetails');
	Route::get('/customers','CustomerController@index');
	Route::get('/customers/{id}','CustomerController@index');
	Route::post('/customers/search','CustomerController@search');
	Route::get('/customer/customerItems/{id}','CustomerController@customerItems');
	Route::get('/purchases/ItemPrice','ItemController@getItemPrice');
	Route::get('/purchase/getExpiryDates','ItemController@getExpiryDate');
	Route::get('/purchases/ItemPurchasePrice','ItemController@getItemPurchasePrice');

	Route::post('/debts/search','DebtController@search');
	Route::post('/debt/store','DebtController@store');
	Route::get('/returns/{id}','ReturnController@index');
	Route::get('/debt/recent/print','DebtController@recent');
	Route::post('/customers/store/{id}','CustomerController@store');


	Route::get('/sales/addSale','SaleController@index');
	Route::post('/sale/create/{id?}','SaleController@create');
	Route::get('/sale/seeSales/{id?}','SaleController@seeSales');
	Route::get('/sale/print/{index}','SaleController@salePrint');
	Route::post('/sale/update/{id}','SaleController@store');

	Route::get('/sale/home',function(){
			return view('sales.saleHome');
		});
	Route::get('sale/search',function(){
			return view('sales.searchSale');
		});
	Route::get('/logout',function(){
		\Auth::logout();
		return redirect('/login');
		});
	
	Route::post('/sale/searchByItem','SaleController@searchByItem')->name('search-sale-byItem');






        	Route::get('/purchases/add',function(){
	    	return view('purchases.addPurchase');
            	});
        Route::post('/debt/confirm/time','DebtController@debtConfirmTime');
    	Route::post('/purchase/create','PurchaseController@store');
    	Route::get('purchase/see/{id?}','PurchaseController@index');
    	Route::get('/purchase/search','PurchaseController@search')->name('search-purchase');
    	Route::post('/purchase/searchByItem','PurchaseController@searchByItem')->name('search-purchase-byItem');
    	Route::post('/purchase/search','PurchaseController@search');
    	Route::get('/purchase/delete/{id}','PurchaseController@delete');
    	Route::get('/purchase/edit/{id}','PurchaseController@edit');
    	Route::post('/purchase/update/{id}','PurchaseController@update');
        Route::get('/returns/edit/{id}',function($id){
		$returnedItem=\App\Ireturn::find($id);
		return view('returns.returnsUpdate',compact('returnedItem'));
	    });
	       Route::get('/returns/payback/{id}','ReturnController@payback');

	    Route::post('/returns/{id?}','ReturnController@store');


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


	Route::post('/reports/noTransactions','CustomerController@noTransactions');
	Route::post('/reports/salesByDate','SaleController@salesByDate');

	Route::post('/reports/mandwb','ItemController@mandwbReports');
	Route::get('/items/itemSaleByGarak/{garak}','ItemController@itemSaleByGarak');
	Route::post('/items/itemSaleByGarakByDate','ItemController@itemSaleByGarakByDate');

	Route::post('/reports/drivers','SaleController@driverReport');
	Route::post('/reports/mandwbSales','SaleController@mandwbSaleReport');
	Route::post('/reports/income','SaleController@income');
	Route::post('/reports/threshold','DebtController@thresholdReport');
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
	
	


