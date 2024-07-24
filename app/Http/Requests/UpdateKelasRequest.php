<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
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
            'kode'=> 'sometimes|required|unique:kelas,kode',
            'keterangan'=> 'required|string|max:50',
            'tahun_ajaran'=> 'required|exists:tahun_ajarans,tahun',
            'guru'=> 'required|exists:gurus,id',

        ];
    }
}
