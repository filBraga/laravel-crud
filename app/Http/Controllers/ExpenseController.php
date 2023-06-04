<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

use App\Http\Requests\ExpenseStoreRequest;

class ExpenseController extends Controller
{
    public function store(ExpenseStoreRequest $request)
    {
        $expense = new Expense;
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->user_id = Auth::id();
        $expense->save();

        // Send an email to the user
        // \Mail::to(Auth::user()->email)->send(new ExpenseRegistered($expense));

        return redirect()->route('home')->with('success', 'Expense added successfully!');
    }

    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->get();

        return view('home', compact('expenses'));
    }

    public function edit(Expense $expense)
    {
        // Retrieve the expense for editing
        // You can pass the $expense object to the edit view
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        // Validate the updated expense data
        $validated = $request->validate([
            'description' => 'required|max:191',
            'date' => 'required|date|before_or_equal:today',
            'amount' => 'required|numeric|min:0',
        ]);

        // Update the expense with the new data
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->save();

        // Redirect back to the expenses index page or any other appropriate page
        return redirect()->route('home')->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        // Delete the expense
        $expense->delete();

        // Redirect back to the expenses index page or any other appropriate page
        return redirect()->route('home')->with('success', 'Expense deleted successfully!');
    }
}
