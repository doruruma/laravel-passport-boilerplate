<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $now = now();
        User::insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('TEST_PASS'),
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
