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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Supprimer uniquement les utilisateurs avec le rôle "client" (garder les admins)
        $clientRole = Role::where('slug', 'client')->first();
        
        if ($clientRole) {
            // Supprimer les relations dans role_user pour les clients
            DB::table('role_user')
                ->where('role_id', $clientRole->id)
                ->delete();
            
            // Supprimer les utilisateurs qui ont UNIQUEMENT le rôle client
            User::whereIn('id', function ($query) use ($clientRole) {
                $query->select('user_id')
                    ->from('role_user')
                    ->where('role_id', $clientRole->id);
            })->delete();
        }

        // Créer 10 000 nouveaux utilisateurs avec le rôle "client"
        User::factory(10000)->create();

        // Récupérer le rôle "client"
        $userRole = Role::where('slug', 'client')->first();

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

            $this->command->info('✓ 10 000 utilisateurs créés avec le rôle "client"');
        } else {
            $this->command->warn('⚠ Le rôle "client" n\'existe pas. Assurez-vous d\'exécuter RoleSeeder en premier.');
        }

        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
