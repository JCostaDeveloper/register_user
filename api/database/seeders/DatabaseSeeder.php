<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(8)->create([
            // 'name' => 'Test User',
            // 'email' => 'test@example.com',
            'birthdate' => Carbon::now()->subYears(27)->format('Y-m-d'),
        ]);
    }
}
