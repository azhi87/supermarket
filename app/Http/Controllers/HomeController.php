<?php

namespace App\Http\Controllers;

use App\Rate;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('status', '1')->get();
        $rate = Rate::latest()->first();
        return view('main.index', compact(['users', 'rate']));
    }
}
