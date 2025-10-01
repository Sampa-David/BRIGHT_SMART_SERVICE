<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index()
    {
        $departments = Department::with('teamMembers')->get();
        return view('equipe', ['departments' => $departments]);
    }
}