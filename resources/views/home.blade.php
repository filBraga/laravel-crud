@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <div class="card-body">

<!-- FORM -->

                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </form>
            </div>

<!-- FORM -->

<!-- TABLE -->
            <div class="divClass">
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="rowClasss">{{ $expense->description }}</td>
                                <td class="rowClasss">{{ $expense->date }}</td>
                                <td class="rowClasss">{{ $expense->amount }}</td>
                                <td class="rowClasss">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

<!-- TABLE -->

            </div>
        </div>
    </div>
</div>

<style>
    .divClass {
        margin: 20px;
        padding: 10px;
        gap: 10px;
        text-align: center;
        /* width: 600px; */
        /* background: red; */
        margin: auto;
    }
    .rowClasss {
        width: 200px;
    }
    form {
        justify-content: center;
        display: flex;
        gap: 10px;
        align-items: flex-end;

    }
    button {
        height: 35px;
    }
</style>

@endsection
