<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Créer le rôle superadmin s'il n'existe pas
        $superadminRole = Role::firstOrCreate(
            ['slug' => 'superadmin'],
            [
                'name' => 'Super Administrateur',
                'description' => 'Accès complet au système'
            ]
        );

        // Créer l'utilisateur superadmin
        $superadmin = User::firstOrCreate(
            ['email' => 'njonoussis@gmail.com'],
            [
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Toulouse',
                'region' => 'Occitanie',
                'state' => 'Haute-Garonne',
                'role' => 'superadmin'
            ]
        );

        // Assigner le rôle superadmin
        $superadmin->roles()->sync([$superadminRole->id]);
    }
}