<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalKegiatanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug'=> 'required|exists:jadwal_kegiatans,id',
            'kelas_id'=> 'required|exists:kelas,id',
            'nama_kegiatan'=> 'required|string|max:100',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string',
            'penanggung_jawab' => 'required|string|max:50',
        ];
    }
}
