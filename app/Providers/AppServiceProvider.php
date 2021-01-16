<?php

namespace App\Providers;

use App\Rate;
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

    // view()->composer('*', function ($view) {
    //   $view->with('rate', \App\Rate::latest()->first());
    // });

    view()->composer(['items.add', 'items.update'], function ($view) {
      $view->with([
        'cats' => \App\Category::all(),
        'items' => \App\Item::latest()->paginate(35),
        'suppliers' => \App\Supplier::all(),
        'mans' => \App\Manufacturer::all(),
      ]);
    });

    view()->composer(['reports.reportHome'], function ($view) {
      $view->with([
        'suppliers' => \App\Supplier::all(),
        'mans' => \App\Manufacturer::all(),
        'users' => \App\User::all(),
      ]);
    });

    view()->composer(['paybacks.payback'], function ($view) {
      $view->with([
        'suppliers' => \App\Supplier::paginate(15)
      ]);
    });

    view()->composer(['purchases.addPurchase', 'purchases.updatePurchase', 'purchases.seePurchase', 'purchases.purchaseReports'], function ($view) {
      $view->with([
        'suppliers' => \App\Supplier::all(),
      ]);
    });

    view()->composer('items.peripheralUpdates', function ($view) {
      $view->with([
        'cats' => \App\Category::all(),
      ]);
    });


    view()->composer(['expenses.expenseHome',  'sales.searchSale'], function ($view) {
      $view->with([
        'rate' => Rate::latest()->first(),
        'users' => \App\User::get()
      ]);
    });


    view()->composer(['sales.addSale', 'sales.updateSale', 'purchases.addPurchase', 'purchases.updatePurchase'], function ($view) {
      $view->with([
        'rate' => Rate::latest()->first(),
      ]);
    });
  }
}
