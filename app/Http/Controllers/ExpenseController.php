<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }
    public function index()
    {
        $expenses = Expense::latest()->paginate(200);
        return view('expenses.expenseHome', compact('expenses'));
    }
    public function  edit(Expense $expense)
    {
        return view('expenses.editExpense', compact('expense'));
    }
    public function store($id = 0)
    {
        $this->validate(request(), [
            "reason" => "required|min:6",
            "amount" => "required|numeric"
        ]);
        if ($id == 0) {
            $expense = new Expense();
            $expense->user_id = auth()->user()->id;
            $message = 'Expense was successfully added!';
        } else {
            $expense = Expense::findOrFail($id);
            $message = " Expnese successfuly updated";
        }
        $expense->amount = request('amount');
        $expense->currency = 'IQD';
        $expense->reason = request('reason');

        if ($expense->save())
            Session::flash('message', $message);

        return redirect('/expenses');
    }

    public function searchReason(Request $request)
    {
        $from = $request['start_date'];
        $to = $request['end_date'];
        $reason = Request('reason');
        $query = Expense::query();

        if (!empty($from))
            $query->whereDate('created_at', '>=', $from);
        if (!empty($to))
            $query->where('created_at', '<=', $to);
        if (!empty('reason'))
            $query->where('reason', 'like', '%' . $reason . '%');

        $expenses = $query->paginate(5000);
        return view('expenses.expenseHome', compact(['expenses', 'from', 'to']));
    }
}
