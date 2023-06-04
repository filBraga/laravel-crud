<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;

use Tests\TestCase;
use App\Models\Expense;
use App\Models\User;

use Database\Factories\ExpenseFactory;

class ExpenseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testExpenseCreation()
    {
        // Perform any necessary setup or preparations
        $user = User::factory()->create(); // Create a new user

        // Call the method being tested
        $expense = Expense::create([
            'description' => 'Test Expense',
            'amount' => 100.00,
            'date' => '2023-06-04',
            'user_id' => $user->id,

            // Provide any other required attributes
        ]);

        // Make assertions to validate the expected behavior
        $this->assertInstanceOf(Expense::class, $expense);
        $this->assertEquals('Test Expense', $expense->description);
        $this->assertEquals(100.00, $expense->amount);
    }

    public function testExpenseIndex()
    {
        // Create a test user
        $user = User::factory()->create();
    
        // Authenticate the user
        $this->actingAs($user);
    
        // Create test expenses for the user
        Expense::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
    
        // Send a GET request to the index route
        $response = $this->get(route('home'));
    
        // Assert that the response has a successful status code (200)
        $response->assertStatus(200);
    
        // Assert that the returned view is 'home'
        $response->assertViewIs('home');
    
        // Assert that the 'expenses' variable is passed to the view and contains the expected data
        $response->assertViewHas('expenses');
    }

    public function testExpenseUpdate()
    {
        // Create a test user
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);
    
        // Create a test expense associated with the authenticated user
        $expense = Expense::factory()->create(['user_id' => $user->id]);
    
        // Send a PUT request to update the expense with a valid date
        $response = $this->put("/expenses/{$expense->id}", [
            'description' => 'Updated Expense',
            'amount' => 200.00,
            'date' => now()->subDay()->format('Y-m-d'), // Set the date to a valid date (before or equal to today)
        ]);
    
        // Assert that the response has a redirect status code (302)
        $response->assertStatus(302);
    
        // Assert that the expense has been updated in the database
        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'description' => 'Updated Expense',
            'amount' => 200.00,
            'date' => now()->subDay()->format('Y-m-d'),
        ]);
    }

    public function testExpenseDelete()
    {
        // Authenticate as a user
        $user = User::factory()->create();
        $this->actingAs($user);
    
        // Create a test expense associated with the authenticated user
        $expense = Expense::factory()->create(['user_id' => $user->id]);
    
        // Send a DELETE request to delete the expense
        $response = $this->delete("/expenses/{$expense->id}");
    
        // Assert that the response has a redirect status code (302)
        $response->assertStatus(302);
    
        // Assert that the expense has been deleted from the database
        $this->assertDatabaseMissing('expenses', [
            'id' => $expense->id,
        ]);
    }
}
