<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('auth.user', compact('users'));
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
            'status' => 'required|integer',
        ]);

        $user->update($request->all());

        return redirect()->route('auth.users')->with('success', 'Utilisateur mis à jour avec succès');
    }
}
