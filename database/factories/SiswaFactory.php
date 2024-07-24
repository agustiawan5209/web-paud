<?php

namespace Database\Factories;

use App\Models\OrangTua;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->firstName(),
            'tempat_lahir' => fake()->city(),
            'tgl_lahir' => fake()->dateTimeBetween('-3 years', '0 years')->format('Y-m-d'),
            'jenkel' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'org_tua_id' =>  OrangTua::factory(),
            'nama_orang_tua'=>  function(array $attribute){
                    return OrangTua::find($attribute['org_tua_id'])->nama;
                },
        ];
    }
}
