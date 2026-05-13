<?php

namespace App\Domain\Auth\Controllers;

use Illuminate\Http\Request;

class MeController
{
    public function me(Request $request)
    {
        $data = $request->user();



        return response()->json($data, 200);
    }
}
