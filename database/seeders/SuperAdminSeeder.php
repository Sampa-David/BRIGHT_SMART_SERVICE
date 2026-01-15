<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate([
            'slug'=>'super-admin',
            'name'=>'Super Administrateur',
            'description '=>'Administrateur en chef ayant tout les privileges disponibles dans la plateforme'
        ]);

        //creons le super administrateur
        $superadmin =  User::firstOrCreate(
            ['email' => 'njonoussis@gmail.com'],
            [
                'username' => 'Wesley',
                'name' => 'NJONOUSSI Stephen',
                'password' => Hash::make('stephBrightCeo'), // Changez ce mot de passe en production
                'email_verified_at' => now(),
                'status' => 'active',
                'location' => 'Bertoua',
                'region' => 'Est',
                'state' => 'Cameroun',
                'role' => 'superadmin'
            ]
        );

        //assigner le role superadmin
        $superadmin->roles->sync([$superAdminRole->id]);
    }
}
