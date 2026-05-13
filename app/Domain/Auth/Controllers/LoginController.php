<?php

namespace App\Domain\Auth\Controllers;

use App\Domain\Auth\Requests\LoginRequest;
use App\Domain\Auth\Actions\LoginUserAction;

class LoginController
{
    public function login(LoginRequest $request, LoginUserAction $action)
    {
        $data = $request->validated();

        $result = $action->execute($data);

        return response()->json($result, 200);
    }
}
