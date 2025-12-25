<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private string $token;

    public function __construct(private UserService $userService)
    {
        $this->token = session('api_token');
        // dd($this->token);
    }

    private function checkAuth()
    {
        if (!$this->token) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        try {
            $users = $this->userService->getAllUsers($this->token);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return view('users.index')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        try {
            $user = $this->userService->getUserById($this->token, $id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('users.create', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $payload = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        try {
            // send raw password — microservice hashes it
            $user = $this->userService->createUser($this->token, $payload);

            return redirect()->route('admin.users.index')->with('success', 'User created');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        try {
            $user = $this->userService->getUserById($this->token, $id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        $payload = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($request->filled('password')) {
            $payload['password'] = $request->password;
        }

        try {
            $this->userService->updateUser($this->token, $id, $payload);

            return redirect()->route('admin.users.index')->with('success', 'User updated');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAuth()) return $redirect;

        try {
            $this->userService->deleteUser($this->token, $id);

            return redirect()->route('admin.users.index')->with('success', 'User deleted');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', $e->getMessage());
        }
    }
}
