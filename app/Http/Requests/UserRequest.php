<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation = [
            'nombre' => ['required', 'string', 'max:100'],
            'cedula' => ['required', 'digits_between:6,12', 'unique:users,cedula'],
            'celular' => ['required', 'digits_between:7,20'],
            'tipo' => ['required', 'in:1,2,3,5,6'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
        ];

        if ($this->user) {
            $validation['cedula'] = ['required', 'digits_between:6,12', 'unique:users,cedula,' . $this->user->id];
            $validation['email'] = ['required', 'email', 'unique:users,email,' . $this->user->id];
            $validation['password'] = ['nullable', 'confirmed', 'min:6'];
        }

        return $validation;
    }
}
