<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Exceptions\AuthException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $user = $this->userRepository->createUser($data);
        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new AuthException("Credenciales inválidas", 401);
        }

        return [
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];
    }

    public function profile()
    {
        return ['user' => auth('api')->user()->load('role')];
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        return ['token' => JWTAuth::refresh($token)];
    }


    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return ['message' => 'Cierre de sesión exitoso'];
    }
}
