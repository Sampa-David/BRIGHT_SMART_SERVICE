<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Créer le rôle superadmin s'il n'existe pas
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => ' Administrateur',
                'description' => 'Accès presque complet au système'
            ]
        );

        // Créer l'utilisateur admin
        $admin = User::firstOrCreate(
            ['email' => 'devbss@gmail.com'],
            [
                'username' => 'Dav',
                'name' => 'Admin',
                'password' => Hash::make('password123'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Toulouse',
                'region' => 'Occitanie',
                'state' => 'Haute-Garonne',
                'role' => 'admin'
            ]
        );

        // Assigner le rôle superadmin
        $admin->roles()->sync([$adminRole->id]);
    }
}