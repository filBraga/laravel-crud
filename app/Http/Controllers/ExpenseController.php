<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|max:191',
            'date' => 'required|date|before_or_equal:today',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense = new Expense;
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->user_id = Auth::id();
        $expense->save();

        // Send an email to the user
        // \Mail::to(Auth::user()->email)->send(new ExpenseRegistered($expense));

        return response()->json($expense, 201);
    }

    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->get();

        return view('home', compact('expenses'));
    }   
}
