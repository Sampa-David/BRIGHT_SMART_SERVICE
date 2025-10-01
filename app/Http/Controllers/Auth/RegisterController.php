<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
   public function showRegistrationForm(){
    return view('auth.register');
   }
   public function register(Request $request){
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg',
            'phone' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'location'=>'nullable|string|',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        User::create([
            'username'=>$request->username,
            'name'=>$request->name,
            'profile_picture'=>$request->profile_picture,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'location'=>$request->location,
            'password'=>Hash::make($request->password)
        ]);
        return redirect()->route('auth.login')->with('success','Inscription réussie');
    }
}
