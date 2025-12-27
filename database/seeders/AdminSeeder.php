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
            ['email' => 'borelmpouma@gmail.com'],
            [
                'username' => 'Borel MPOUMA',
                'name' => 'MPOUMA',
                'password' => Hash::make('borelCom2.0'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Bertoua',
                'region' => 'Est',
                'state' => 'Cameroun',
                'role' => 'admin'
            ]
        );

        // Assigner le rôle superadmin
        $admin->roles()->sync([$adminRole->id]);
    }
}