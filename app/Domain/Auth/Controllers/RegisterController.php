<?php

namespace App\Domain\Auth\Controllers;

use App\Domain\Auth\Requests\RegisterRequest;
use App\Domain\Auth\Actions\RegisterUserAction;

class RegisterController
{
    public function store(RegisterRequest $request, RegisterUserAction $action)
    {
        $data = $request->validated();

        $result = $action->execute($data);

        return response()->json($result, 201);
    }
}
