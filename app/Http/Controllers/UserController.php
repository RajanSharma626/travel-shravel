<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNull('deleted_at')->with('roles')->orderBy('created_at', 'desc')->get();
        $roles = Role::all();

        return view('users', compact('users', 'roles'));
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

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Keep for backward compatibility
            'password' => Hash::make($request->password),
            'status' => 'Active',
        ]);

        // Assign role using Spatie
        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->assignRole($role);
        }

        // Redirect back with a success message
        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->first()?->name ?? $user->role,
            'status' => $user->status,
        ]);
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

        // Find the user
        $user = User::findOrFail($request->id);

        // Update the user's details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role; // Keep for backward compatibility
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync roles using Spatie
        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->syncRoles([$role]);
        }

        // Redirect back with a success message
        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
}
