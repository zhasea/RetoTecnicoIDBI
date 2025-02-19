<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $response = $this->authService->register($request->all());
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $response['user'],
            'token' => $response['token']
        ], 201);
    }

    public function login(Request $request)
    {
        $response = $this->authService->login($request->only(['email', 'password']));
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $response['token'],
            'expires_in' => $response['expires_in'],
            'user' => $response['user']
        ]);
    }

    public function profile()
    {
        return response()->json($this->authService->profile());
    }

    public function refresh()
    {
        return response()->json($this->authService->refresh());
    }

    public function logout()
    {
        return response()->json($this->authService->logout());
    }
}
