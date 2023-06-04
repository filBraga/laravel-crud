<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $policy = ExpensePolicy::class;

    use HasFactory;

    // Specify the table name if it differs from "expenses"
    // protected $table = 'your_table_name';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'description',
        'date',
        'amount',
        'user_id',
    ];

    // Define any relationships or additional methods here
}
