<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les vérifications de clés étrangères pour une meilleure performance
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Créer 10 000 utilisateurs avec le rôle "user"
        User::factory(10000)->create();

        // Récupérer le rôle "user"
        $userRole = Role::where('slug', 'user')->first();

        // Si le rôle existe, attribuer le rôle à tous les utilisateurs créés
        if ($userRole) {
            // Obtenir tous les utilisateurs (sauf les admins et superadmin)
            $users = User::whereNotIn('role', ['admin', 'superadmin'])->get();

            // Attribuer le rôle en batch
            foreach ($users->chunk(500) as $chunk) {
                $roleUserData = $chunk->map(function ($user) use ($userRole) {
                    return [
                        'user_id' => $user->id,
                        'role_id' => $userRole->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray();

                DB::table('role_user')->insertOrIgnore($roleUserData);
            }

            $this->command->info('✓ 10 000 utilisateurs créés avec le rôle "user"');
        } else {
            $this->command->warn('⚠ Le rôle "user" n\'existe pas. Assurez-vous d\'exécuter RoleSeeder en premier.');
        }

        // Réactiver les vérifications de clés étrangères
        //DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
