<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.UserList', compact('users'));
    }

    
    public function show(User $user)
    {
        return view('users.UserShow', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.UserEdit', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username'=>'required|string|max:20|unique:users',
            'first_name'=>'required|string|max:15',
            'last_name'=>'nullable|string|max:15',
            'sexe'=>'required|in:masculin,feminin',
            'birth_date'=>'required|date|before:'.now()->subYears(15)->format('Y-m-d'),
            'email'=>'required|string|email|max:50|unique:users',
            'phone'=>'required|string|max:20|unique:users',
            'address'=>'nullable|string|max:50',
            'profile_picture'=>'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'social_media_links'=>'nullable|string',
            'password'=>'required|string|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@"#$%&+]/',
        ]);

        if($request->hasFile('profile_picture')){
            $image = $request->file('profile_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/profile_picture'), $imageName);
            $data['profile_picture'] = 'uploads/profile_picture/'.$imageName;
        }

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->back()->with('success','Enregistrement effectué avec succès');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username'=>'required|string|max:20|unique:users,username,'.$user->id,
            'first_name'=>'required|string|max:15',
            'last_name'=>'nullable|string|max:15',
            'sexe'=>'required|in:masculin,feminin',
            'birth_date'=>'required|date|before:'.now()->subYears(15)->format('Y-m-d'),
            'email'=>'required|string|email|max:50|unique:users,email,'.$user->id,
            'phone'=>'required|string|max:20|unique:users,phone,'.$user->id,
            'address'=>'nullable|string|max:50',
            'profile_picture'=>'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'social_media_links'=>'nullable|string',
            'password'=>'nullable|string|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@"#$%&+]/',
        ]);

        if($request->hasFile('profile_picture')){
            $image = $request->file('profile_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/uploads/profile_picture'), $imageName);
            $data['profile_picture'] = 'uploads/profile_picture/'.$imageName;
        }

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','Vos informations ont été mises à jour avec succès');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success','Utilisateur supprimé avec succès');
    }

    public function dashboard(){
        return view('users.dashboardUser');
    }
}

