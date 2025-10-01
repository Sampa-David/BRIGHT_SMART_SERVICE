<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::create([
                'name' => $validated['name'],
                'slug' => Role::createSlug($validated['name']),
                'description' => $validated['description'],
                'is_system' => false
            ]);
            
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la création du rôle.');
        }
    }

    public function edit(Role $role)
    {
        if ($role->isSystemRole()) {
            return back()->with('error', 'Les rôles système ne peuvent pas être modifiés.');
        }
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->isSystemRole()) {
            return back()->with('error', 'Les rôles système ne peuvent pas être modifiés.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            $role->update([
                'name' => $validated['name'],
                'slug' => Role::createSlug($validated['name']),
                'description' => $validated['description']
            ]);
            
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du rôle.');
        }
    }

    public function destroy(Role $role)
    {
        if ($role->isSystemRole()) {
            return back()->with('error', 'Les rôles système ne peuvent pas être supprimés.');
        }

        try {
            DB::beginTransaction();
            
            // Détacher tous les utilisateurs avant la suppression
            $role->users()->detach();
            $role->delete();
            
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression du rôle.');
        }
    }

    public function assignRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::findOrFail($validated['role_id']);

        if ($role->isSystemRole() && !auth()->user()->hasRole('superadmin')) {
            return back()->with('error', 'Vous n\'avez pas la permission d\'attribuer ce rôle.');
        }

        try {
            $user->roles()->syncWithoutDetaching([$role->id]);
            return back()->with('success', 'Rôle attribué avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'attribution du rôle.');
        }
    }

    public function removeRole(Request $request, User $user, Role $role)
    {
        if ($role->isSystemRole() && $user->roles()->count() === 1) {
            return back()->with('error', 'Impossible de retirer le dernier rôle système d\'un utilisateur.');
        }

        try {
            $user->roles()->detach($role);
            return back()->with('success', 'Rôle retiré avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors du retrait du rôle.');
        }
    }
}
