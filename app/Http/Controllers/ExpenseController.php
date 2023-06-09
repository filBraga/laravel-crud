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
        $this->authorize('create', Expense::class);

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
        $this->authorize('viewAny', Expense::class);

        $expenses = Expense::where('user_id', Auth::id())->get();

        return view('home', compact('expenses'));
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);

        // Retrieve the expense for editing
        // You can pass the $expense object to the edit view
        return view('expenses.edit', compact('expense'));
    }

    public function update(ExpenseStoreRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

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
        $this->authorize('delete', $expense);

        $expense->delete();

        // Redirect back to the expenses index page or any other appropriate page
        return redirect()->route('home')->with('success', 'Expense deleted successfully!');
    }
}
