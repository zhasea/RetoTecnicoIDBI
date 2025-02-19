<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createUser(array $data)
    {
        try {
            return User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'],
            ]);
        } catch (\Exception $e) {
            throw new RepositoryException("Error al crear usuario.");
        }
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
