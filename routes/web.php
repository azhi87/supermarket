<?php

use App\Broken;
use App\Item;
use Illuminate\Support\Facades\Route;

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

// use Illuminate\Routing\Route;

Auth::routes();
Route::middleware(['auth'])->group(function () {

	Route::get('/', 'HomeController@index');




	Route::get('/home', 'HomeController@index')->name('home');


	Route::get('/items/add', 'ItemController@create');
	Route::get('/items/edit/{id}', 'ItemController@edit')->name('edit-item');
	Route::post('/items/update/{id}', 'ItemController@store')->name('update-item');
	Route::post('/cats/add', 'ItemController@addCategory')->name('add-category');
	Route::post('/items/search', 'ItemController@search');
	Route::post('/items/searchName', 'ItemController@searchName');
	Route::post('/items/store', 'ItemController@store');

	Route::get('/sale/delete/{id}', 'SaleController@destroy')->name('delete-sale');
	Route::get('/suppliers', 'SupplierController@index')->name('show-suppliers');
	Route::post('/suppliers/search', 'SupplierController@search')->name('search-supplier');
	Route::post('/suppliers/store/{id?}', 'SupplierController@store')->name('store-supplier');
	Route::get('/suppliers/edit/{id}', 'SupplierController@edit')->name('edit-supplier');

	Route::post('/category/edit/{id}', 'CategoryController@update');

	Route::post('/stock/expiry', 'StockController@stockExpiry');
	Route::get('/sale/ok/{id}', 'SaleController@ok');


	Route::get('reports/stockValuation', 'ReportController@stockValuation')->name('show-stock-valuations');
	Route::get('/reports/stock', 'ReportController@showStock')->name('show-stock');
	Route::post('/reports/supplierDebt', 'ReportController@supplierDebt')->name('supplier-debt-report')->middleware('admin');
	Route::post('/reports/profit', 'ReportController@profit')->name('show-profit')->middleware('admin');
	Route::post('/stock/manufacturer', 'ReportController@showStockByManufacturer')->name('show-stock-byManufacturer');
	Route::post('/stock/stockByItem', 'ReportController@stockByItem')->name('show-item-stock');

	Route::post('/sale/search', 'SearchController@searchSale')->name('search-sale');
	Route::view('/sale/search', 'sales.searchSale')->name('search-sale');
	Route::post('/sale/searchId', 'SaleController@search');

	Route::get('/sale/edit/{index}', 'SaleController@edit')->name('edit-sale');

	Route::post('/sale/mandwbTotalByDate', 'SaleController@mandwbTotalByDate');

	Route::get('/purchases/ItemPrice', 'ItemController@getItemPrice');
	Route::get('/purchase/getExpiryDates', 'ItemController@getExpiryDate');
	Route::get('/purchases/ItemPurchasePrice', 'ItemController@getItemPurchasePrice');

	Route::get('/sales/addSale', 'SaleController@index')->name('add-sale');
	Route::post('/sale/create/{id?}', 'SaleController@create')->name('store-sale');
	Route::get('/sale/seeSales/{id?}', 'SaleController@seeSales')->name('show-sales');
	Route::get('/sale/print/{index}', 'SaleController@salePrint')->name('print-sale');
	Route::post('/sale/update/{id}', 'SaleController@store')->name('update-sale');

	Route::view('/sale/home', 'sales.saleHome')->name('sale-home');
	Route::view('sale/search', 'sales.searchSale');
	Route::get('/logout', function () {
		\Auth::logout();
		return redirect('/login');
	});

	Route::post('/sale/searchByItem', 'SaleController@searchByItem')->name('search-sale-byItem');
	Route::get('/sale/viewReturned', 'SaleController@viewReturned')->name('view-returned-sales');

	Route::view('/purchases/add', 'purchases.addPurchase')->name('add-purchase');
	Route::post('/purchase/create/{id?}', 'PurchaseController@store')->name('store-purchase');
	Route::get('purchase/see/{id?}', 'PurchaseController@index')->name('show-purchases');
	Route::get('purchase/viewReturned/{id?}', 'PurchaseController@viewReturned')->name('view-returned-purchases');
	Route::get('/purchase/search', 'PurchaseController@search')->name('search-purchase');
	Route::get('/purchase/supplier/{id}', 'PurchaseController@showSupplierPurchases')->name('show-supplier-purchases');
	Route::post('/purchase/searchByItem', 'PurchaseController@searchByItem')->name('search-purchase-byItem');
	Route::get('/purchase/delete/{id}', 'PurchaseController@delete')->name('delete-purchase');
	Route::get('/purchase/edit/{id}', 'PurchaseController@edit')->name('edit-purchase');
	Route::view('/purchase/home', 'purchases.purchaseHome')->name('purchase-home');

	Route::get('/expenses', 'ExpenseController@index')->name('expenses');
	Route::post('/expenses/store/{id?}', 'ExpenseController@store')->name('store-expense');
	Route::post('/expenses/search', 'ExpenseController@search');
	Route::post('/expenses/searchReason', 'ExpenseController@searchReason');

	Route::get('/expenses/edit/{expense}', 'ExpenseController@edit')->name('edit-expense');

	Route::post('/reports/salesByDate', 'SaleController@salesByDate');

	Route::post('/reports/mandwb', 'ItemController@mandwbReports');
	Route::post('/reports/mandwbSales', 'SaleController@mandwbSaleReport');
	Route::post('/reports/income', 'ReportController@income')->name('income-money')->middleware('admin');
	Route::post('/reports/incomeByUser', 'ReportController@incomeByUser')->name('show-income-byUser')->middleware('admin');;
	Route::post('/reports/returnedItems', 'ReturnController@report');

	Route::view('/items/updateAlldrugs', 'items.updateAlldrugs', [
		'items' => Item::paginate(20)
	]);
	Route::livewire('/live-items', 'add-item')->layout('layouts.master')->name('add-item');
	Route::livewire('/show-items', 'show-item')->layout('layouts.master')->name('show-items');
	Route::livewire('/manufacturer/add', 'add-manufacturer')->layout('layouts.master')->name('add-manufacturer');
	Route::livewire('/show-popular-items', 'item-popularity')->layout('layouts.master')->name('show-popular-items');
	Route::livewire('/item/transactions/{id?}', 'item-transactions')->layout('layouts.master')->name('show-item-transactions');

	Route::view('/brokens', 'brokens.brokenHome')->name('show-brokens');

	Route::view('/peripheralUpdates', 'items.peripheralUpdates');

	Route::post('/rate/add', 'RateController@create');
	Route::post('/rate', function () {
		$rate = new \App\Rate;
		$rate->rate = Request('rate');
		$rate->user_id = auth()->user()->id;
		$rate->save();
		return redirect('/');
	});

	Route::get('/paybacks/{id?}', 'PaybackController@index')->name('payback');
	Route::post('/paybacks/store/{id?}', 'PaybackController@store')->name('store-payback');
	Route::get('/payback/edit/{id}', 'PaybackController@edit')->name('edit-payback');
	Route::get('/paybacks/print/{id}', 'PaybackController@printing')->name('print-payback');

	Route::post('/drugs/searchAjax', function () {
		$search = request()->search;

		if ($search == '') {
			$items = \App\Item::orderby('name', 'asc')->select('id', 'name')->limit(0)->get();
		} else {
			$items = \App\Item::where(function ($q) use ($search) {
				$q->where('name', 'like', '%' . $search . '%')
					->orWhere('barcode', 'like', '%' . $search . '%');
			})->limit(5)->get();
		}

		$response = array();
		foreach ($items as $item) {
			$response[] = array(
				"id" => $item->id,
				"text" => $item->name
			);
		}

		echo json_encode($response);
		exit;
	});
	Route::view('/reports', 'reports.reportHome');
});

Route::middleware(['admin'])->group(function () {
	Route::get('/users/edit/{id}', 'UserController@edit')->name('edit-user');
	Route::post('/users/update/{id}', 'UserController@updateUser')->name('update-user');
	Route::get('/users', 'UserController@showUsers');
	Route::get('/users/toggle/{id}', 'UserController@toggleUser');
});
