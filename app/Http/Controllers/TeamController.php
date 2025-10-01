<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $teamMembers = TeamMember::with('department')->get();
        return view('dashboards.sections.team', compact('departments', 'teamMembers', 'departments'));
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

        return redirect()->back()->with('success', 'Team member added successfully!');
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
            // Delete old image
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            
            $path = $request->file('image')->store('team-members', 'public');
            $validated['image'] = $path;
        }

        $teamMember->update($validated);

        return redirect()->back()->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }

        $teamMember->delete();

        return redirect()->back()->with('success', 'Team member deleted successfully!');
    }
}