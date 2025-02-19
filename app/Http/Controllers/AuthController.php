<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
     /**
     * Registro de un usuario
     */
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->validated());
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $response['user'],
            'token' => $response['token']
        ], 201);
    }
     /**
     * Login de un usuario
     */
    public function login(LoginRequest $request)
    {
        $response = $this->authService->login($request->validated());
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'token' => $response['token'],
            'expires_in' => $response['expires_in'],
            'user' => $response['user']
        ]);
    }

     /**
     * Perfil de un usuario
     */
    public function profile()
    {
        return response()->json($this->authService->profile());
    }

     /**
     * Refresh token 
     */
    public function refresh()
    {
        return response()->json($this->authService->refresh());
    }

     /**
     * Cerrar sesion
     */
    public function logout()
    {
        return response()->json($this->authService->logout());
    }
}
