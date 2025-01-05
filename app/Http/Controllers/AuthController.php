<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi menampilkan form register
    public function showRegisterForm()
    {
        return view('register');
    }

    // Fungsi untuk proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    // Fungsi menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Fungsi untuk proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Cek kredensial
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/dashboard')->with('success', 'You are logged in');
        }

        // Jika login gagal
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
