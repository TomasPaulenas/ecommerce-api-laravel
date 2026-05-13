<?php

namespace App\Domain\Auth\Actions;


use App\Models\User;

class RegisterUserAction
{
    public function execute(array $data)
    {
        $entity = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => ($data['password']),
        ]);

        $token = $entity->createToken('api-token')->plainTextToken;

        return [
            'entity' => $entity,
            'token' => $token,
        ];
    }
}
