<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installation

1. Clone the repository
    ```
    git clone https://github.com/filBraga/laravel-crud
    ```
2. Install PHP dependencies
    ```
    composer install && npm install
    ```
3. Create and set up your `.env` file, then run migrations
    ```
    php artisan migrate
    ```
4. Run seed
    ```
    php artisan seed
    ```
5. Run the application
    ```
    php artisan serve
    ```
    and
    ```
    npm run dev
    ```

extra: For login:

    'email' => 'john@example.com',
    'password' => 'password',

    or

    'email' => 'jane@example.com',
    'password' => 'password',

## Test

1. Run the tests
    ```
    php artisan test
    ```

## Usage

You need to register and log in to use the application. Once logged in, you can create, view, edit, and delete expenses from the home page.

Expenses have 'description', 'date', 'amount' and 'user_id'

Model:

    ```
    // Expense.php

    protected $fillable = [
        'description',
        'date',
        'amount',
        'user_id',
    ];
    ```

Validations:

    ```
    // ExpenseStoreRequest.php

    'description' => 'required|max:191',
    'date' => 'required|date|before_or_equal:today',
    'amount' => 'required|numeric|min:0',
    ```

Policy access:

    ```
    // ExpenseController.php

    $this->authorize('create', Expense::class);
    $this->authorize('viewAny', Expense::class);
    $this->authorize('update', $expense);
    $this->authorize('update', $expense);
    $this->authorize('delete', $expense);

    // ExpensePolicy.php

    return $user->id === $expense->user_id;
    ```

Email not implemented:

    ```
    // ExpenseController.php

    // Send an email to the user
    // \Mail::to(Auth::user()->email)->send(new ExpenseRegistered($expense));
    ```

## Features

-   User registration and authentication
-   Creating, viewing, updating, and deleting expenses
-   View list of all expenses for a user
