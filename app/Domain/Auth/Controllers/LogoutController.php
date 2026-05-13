<?php

namespace App\Domain\Auth\Controllers;

use Illuminate\Http\Request;

class LogOutController
{
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();



        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
