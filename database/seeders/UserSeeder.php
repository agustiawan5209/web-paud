<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org = User::factory(30)
            ->afterCreating(function (User $user) {
                $role = Role::findByName('Orang Tua'); // Replace 'user' with your actual role name
                if ($role) {
                    $user->assignRole($role); // Assign 'user' role to the user
                }
                $user->givePermissionTo([
                    'show nilai',
                    'show kegiatan',
                    'show siswa',
                ]);
            })
            ->has(OrangTua::factory()
                ->has(Siswa::factory()->count(3))
                ->count(1))
            ->create();

        $org = User::factory(10)
            ->afterCreating(function (User $user) {
                $role = Role::findByName('Guru'); // Replace 'user' with your actual role name
                if ($role) {
                    $user->assignRole($role); // Assign 'user' role to the user
                    $user->givePermissionTo([
                        'add nilai',
                        'edit nilai',
                        'delete nilai',
                        'show nilai',
                    ]);
                }

                Guru::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'alamat' => fake()->address(),
                ]);
            })
            ->create();
    }
}
