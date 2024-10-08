<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAbsensiRequest extends FormRequest
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
            'slug'=> 'required|exists:absensis,id',
            'kelas_id'=> 'required|exists:kelas,id',
            'siswa'=> 'required|array',
            'tanggal'=> 'required|date',
            'siswa.*.absen'=> 'required|in:Hadir,Tidak Hadir'
        ];
    }
}
