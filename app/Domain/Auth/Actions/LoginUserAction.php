<?php

namespace App\Domain\Auth\Actions;


use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginUserAction
{
    public function execute(array $data)
    {
        $user = User::where(
            'email',
            $data['email'],
        )->first();

        if (!$user) {
            return null;
        }

        if (!Hash::check($data['password'], $user->password)) {
            return null;
        }


        $token = $user->createToken('api-token')->plainTextToken;




        return [
            'entity' => $user,
            'token' => $token,

        ];
    }
}
