<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Create the users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Redirect back with a success message
        return redirect()->route('users')->with('success', 'users created successfully.');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return response()->json($users);
    }

    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        // Find the users
        $users = User::findOrFail($request->id);

        // Update the users's details
        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->role;
        $users->status = $request->status;

        if ($request->password) {
            $users->password = Hash::make($request->password);
        }

        $users->save();

        // Redirect back with a success message
        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
}
