<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->name = 'John Doe';
        $user->email = 'john@example.com';
        $user->password = Hash::make('password');
        $user->save();
    }
}