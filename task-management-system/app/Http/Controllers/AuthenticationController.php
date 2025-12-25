<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function CreateUserWithEmailAndPassword(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ];

        $response = Http::post('http://auth-service:8000/api/register', $userData);
        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        } else {
            return redirect()->back()->withErrors(['registration_error' => 'Registration failed. Please try again.']);
        }
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $response = Http::post('http://auth-service:8000/api/login', $credentials);

        if ($response->successful()) {
            $data = $response->json();

            // Store token in session
            session(['api_token' => $data['token']]);

            // Optionally store user data as well
            if (isset($data['user'])) {
                session(['api_user' => $data['user']]);
            }

            return redirect()->route('admin.users.index')->with('success', 'Login successful!');
        } else {
            // Handle failed login
            return redirect()->back()->withErrors(['login_error' => 'Invalid credentials.']);
        }
    }

    public function logout(Request $request)
    {
        // Clear API token and user data from session
        $request->session()->forget(['api_token', 'api_user']);

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
