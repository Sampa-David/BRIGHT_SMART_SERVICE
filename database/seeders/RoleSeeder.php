<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $systemRoles = [
            [
                'name' => 'Super Admin',
                'slug' => 'superadmin',
                'description' => 'Administrateur principal du système',
                'is_system' => true
            ],
            [
                'name' => 'Administrateur',
                'slug' => 'admin',
                'description' => 'Administrateur avec des privilèges limités',
                'is_system' => true
            ],
            [
                'name' => 'Client',
                'slug' => 'client',
                'description' => 'Utilisateur standard',
                'is_system' => true
            ]
        ];

        foreach ($systemRoles as $role) {
            Role::create($role);
        }
    }
}