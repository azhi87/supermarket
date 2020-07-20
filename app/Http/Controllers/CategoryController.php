<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function update($id){
        $cat=\App\Category::find($id);
        $cat->category=request('category');
        $cat->save();
        return redirect('/live-items')->withMessage('Category name was successfuly Update');
    }
}
