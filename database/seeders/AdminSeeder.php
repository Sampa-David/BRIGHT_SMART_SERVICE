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
            ['email' => 'davidsampa@gmail.com'],
            [
                'username' => 'Le Roi',
                'name' => 'Sampa David',
                'password' => Hash::make('Admindevbss2.0'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Dschang',
                'region' => 'Ouest',
                'state' => 'Cameroun',
                'role' => 'admin'
            ]
        );

        // Assigner le rôle admin
        $admin->roles()->sync([$adminRole->id]);

        $admin = User::firstOrCreate(
            ['email' => 'ornelanyablondel@gmail.com'],
            [
                'username' => 'Blondelle',
                'name' => 'NYA Blondelle',
                'password' => Hash::make('@nyaBlondPro2.0'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Douala',
                'region' => 'Littoral',
                'state' => 'Cameroun',
                'role' => 'admin'
            ]
        );

        // Assigner le rôle admin
        $admin->roles()->sync([$adminRole->id]);

        
        $admin = User::firstOrCreate(
            ['email' => 'borelmpouma@gmail.com'],
            [
                'username' => 'Borel',
                'name' => 'MPOUMA Borel',
                'password' => Hash::make('borelCom2.0'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Bertoua',
                'region' => 'Est',
                'state' => 'Cameroun',
                'role' => 'admin'
            ]
        );

        // Assigner le rôle admin
        $admin->roles()->sync([$adminRole->id]);

    }
}