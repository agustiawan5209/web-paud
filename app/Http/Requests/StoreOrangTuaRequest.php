<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrangTuaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => '|required|string|max:50',
            'no_telpon' => '|required|string|max:13',
            'alamat' => '|required|string|max:100',
            'nama_ayah' => 'nullable|string|max:50',
            'alamat_ayah' => 'nullable|string|max:100',
            'no_telpon_ayah' => 'nullable|string|max:13',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'string'],
        ];
    }
}
