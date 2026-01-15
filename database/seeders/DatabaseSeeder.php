<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@brightsmartservice.com',
            'password' => bcrypt('password'),
            'location' => 'Toulouse',
            'region' => 'Occitanie',
            'state' => 'Haute-Garonne',
        ]);

        $this->call([
            
            AdminSeeder::class,
            SuperAdminSeeder::class
        ]);
    }
}
