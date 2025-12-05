<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\UsersClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthenticationController extends Controller
{
    protected $usersClient;


    public function __construct(UsersClient $usersClient)
    {
        $this->usersClient = $usersClient;
    }


    public function validateToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            return response()->json(['valid' => true, 'payload' => (array) $decoded]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        $user = $this->usersClient->getByEmail($request->email);


        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }


        // users-service returns hashed password field as `password`
        if (!Hash::check($request->password, $user['password'])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }


        $now = time();
        $ttl = (int) env('JWT_TTL', 3600); // seconds


        $payload = [
            'sub' => $user['id'],
            'email' => $user['email'],
            'iat' => $now,
            'exp' => $now + $ttl,
            // add any custom claims you want
            'role' => $user['role'] ?? null,
        ];


        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');


        unset($user['password']);


        return response()->json([
            'token' => $token,
            'expires_in' => $ttl,
            'user' => $user,
        ]);
    }


    public function register(Request $request)
    {
        // optional: proxy registration to users-service
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        $payload = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password,
        ];

        // dd($payload);

        $user = $this->usersClient->createUser($payload);


        if (!$user) return response()->json(['error' => "Registration failed {{$user}}"], 500);


        unset($user['password']);
        return response()->json(['user' => $user], 201);
    }
}
