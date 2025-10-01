<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::with('department')->get();
        $departments = Department::all();
        return view('admin.team.index', compact('teamMembers', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'department_id' => 'required|exists:departments,id'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('team-members', 'public');
            $validated['image'] = $path;
        }

        TeamMember::create($validated);

        return redirect()->route('team.index')->with('success', 'Membre ajouté avec succès !');
    }

    public function edit(TeamMember $teamMember)
    {
        return response()->json($teamMember);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'department_id' => 'required|exists:departments,id'
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            
            $path = $request->file('image')->store('team-members', 'public');
            $validated['image'] = $path;
        }

        $teamMember->update($validated);

        return redirect()->route('team.index')->with('success', 'Membre mis à jour avec succès !');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }

        $teamMember->delete();

        return redirect()->route('team.index')->with('success', 'Membre supprimé avec succès !');
    }
}