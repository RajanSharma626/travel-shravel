<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|min:6',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user->status != 'Active') {
            return back()->with('error', 'Your account is Deactive. Please contact admin.');
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Redirect based on user role
            $role = Auth::user()->role;

            switch ($role) {
                case 'Admin':
                    return redirect('/');
                case 'Manager':
                    return redirect('/leads');
                case 'Agent':
                    return redirect('/leads');
                case 'Underwriter':
                    return redirect('/underwriting');
                default:
                    return redirect('/home');
            }
        }

        return back()->with('error', 'Invalid users ID or Password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
