<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrangTua>
 */
class OrangTuaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::factory(),
            'nama'=> function(array $attribute){
                return User::find($attribute['user_id'])->name;
            },
            'alamat'=> fake()->address(),
            'no_telpon'=> function(array $attribute){
                return User::find($attribute['user_id'])->phone;
            },
        ];
    }
}
