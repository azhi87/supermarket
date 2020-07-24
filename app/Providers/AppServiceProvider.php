<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
  use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

             view()->composer('*',function($view) {
            //$view->with('user', \Auth::user()->first());
            $view->with('rate', \App\Rate::latest()->first()); 
        });

          view()->composer(['items.add','items.update'],function($view){
        $view->with([
                'cats'=>\App\Category::all(),
                'items'=>\App\Item::latest()->paginate(35),
                'suppliers'=>\App\Supplier::all(),
                'mans'=>\App\Manufacturer::all(),
            ]);
             });

         view()->composer(['reports.reportHome'],function($view){
        $view->with([
                'suppliers'=>\App\Supplier::all(),
                'mans'=>\App\Manufacturer::all(),
            ]);
             });

          view()->composer('main.index',function($view){
        $view->with([
            'users'=>\App\User::where('email','!=','techsaz@gmail.com')->get(),
            ]);
             });

          view()->composer(['suppliers.suppliersHome','paybacks.payback'],function($view){
          $view->with([
            'suppliers'=>\App\Supplier::paginate(15)
            ]);
        });

           view()->composer(['purchases.addPurchase','purchases.updatePurchase'],function($view){
          $view->with([
            'suppliers'=>\App\Supplier::all(),
            ]);
        });

          view()->composer('items.peripheralUpdates',function($view){
        $view->with([
            'cats'=>\App\Category::all(),
            ]);
             });


           view()->composer(['expenses.expenseHome','staff.staffHome','sales.searchSale'],function($view){
          $view->with([
            'users'=>\App\User::get()
            ]);
        });


           view()->composer(['sales.addSale','sales.updateSale','purchases.addPurchase','purchases.updatePurchase'],function($view){
          $view->with([
              'drugs'=>\App\Item::all(),
            ]);
        });
    }
}
