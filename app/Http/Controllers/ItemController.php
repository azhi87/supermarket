<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;

use Storage;
use App\Category;
use File;

class ItemController extends Controller
{
   public function create()
   {
      return view('items.add');
   }
   public function store(Request $request, $id = 0)
   {

      if ($id != 0) {
         $item = Item::find($id);
         //   $item->status=request('status');
         $text = "گۆڕانکاریەکە بەسەرکەوتوویی تۆمارکرا کرا";
      } else {
         $item = new Item;
         $text = "مەوادەکە بەسەرکەوتوویی زیاد کرا";
      }
      $this->validate(
         request(),
         [
            "sale_price_id" => "required",
            "name" => "required|min:1",
            "id" => 'unique:items',
         ]
      );





      $item->barcode = request('barcode');
      $item->name = request('name');
      $item->name_en = request('name_en');
      $item->manufacturer_id = request('manufacturer_id');
      $item->items_per_box = request('items_per_box');
      $item->sale_price_id = request('sale_price_id');

      if (null !== (Request('purchase_price'))) {
         $item->purchase_price = request('purchase_price');
      }
      $item->category_id = request('category_id');
      $item->supplier_id = request('supplier_id');
      $item->maxzan = request('maxzan');
      $item->description = request('description');
      $item->save();
      \Session::flash('message', $text);
      return redirect('/live-items');
   }
   public function search()
   {
      $id = request('id');
      $searchItems = Item::notDeleted()->find($id);
      if (count($searchItems))
         $searchItems = array($searchItems);
      return view('items.add', compact('searchItems'));
   }
   public function searchName()
   {
      $name = request('name');
      $items = Item::notDeleted()->where('name', 'like', '%' . $name . '%')->get();
      return view('items.add', compact('items'));
   }


   public function addCategory()
   {
      $this->validate(
         request(),
         [
            "cat" => "required|unique:categories,category"
         ]
      );
      $text = request('cat');
      DB::table('categories')->insert(['category' => $text]);
      $text = "جۆری مەواد (" . $text . ")زیاد کرا";
      \Session::flash('message', $text);
      return redirect('/live-items');
   }

   public function edit($id)
   {
      $item = Item::find($id);
      $cats = Category::all();
      $suppliers = \App\Supplier::all();
      return view('items.update', compact('item', 'cats', 'suppliers'));
   }

   public function delete($id)
   {
      $item = Item::find($id);
      $item->update('status', '0');
   }

   public function getItemPrice()
   {
      $item = Item::notDeleted()->find(request('barcode'));
      return json_encode(array("price" => $item->sale_price_id, "name" => $item->name, "items_per_box" => $item->items_per_box, "dates" => $item->expiryDates()));
   }

   public function getExpiryDate()
   {
      $item_id = (request('barcode'));
      $item = Item::find($item_id);
      return response()->json($item->expiryDates());
   }
   public function getItemPurchasePrice()
   {
      $item = Item::notDeleted()->find(request('barcode'));
      return json_encode(array("price" => $item->purchase_price, "sale_price" => $item->sale_price_id, "name" => $item->name, "items_per_box" => $item->items_per_box));
   }

   public function mandwbReports(Request $request)
   {

      $user = \App\User::find($request['user_id']);
      $to = $request['to'];
      $from = $request['from'];
      $sales = \App\Sale::where('user_id', $user->id)->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();
      return view('reports.monthlyMandwb', compact(['from', 'to', 'user', 'sales']));
   }
}
