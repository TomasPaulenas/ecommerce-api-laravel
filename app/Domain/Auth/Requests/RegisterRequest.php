<?php

namespace App\Domain\Auth\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{



    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [

            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:22'],



        ];
    }
}
