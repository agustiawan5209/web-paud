<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $role_orangtua = Role::create(['name' => 'Orang Tua']);
        $role_guru = Role::create(['name' => 'Guru']);



        $user = User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '123456780',
        ]);

        $user->assignRole($role);
        $user->givePermissionTo([
            'add kelas',
            'edit kelas',
            'delete kelas',
            'show kelas',

            'add guru',
            'edit guru',
            'delete guru',
            'show guru',
            'reset guru',

            'add orangtua',
            'edit orangtua',
            'delete orangtua',
            'show orangtua',
            'reset orangtua',

            'add siswa',
            'edit siswa',
            'delete siswa',
            'show siswa',
        ]);


        $guru = User::factory()->create([
            'name' => 'guru',
            'username' => 'guru',
            'email' => 'guru@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '081524269051',
        ]);
        $role = Role::findByName('Guru'); // Replace 'user' with your actual role name
        if ($role) {
            $guru->assignRole($role); // Assign 'guru' role to the user
            $guru->givePermissionTo([
                'add nilai',
                'edit nilai',
                'delete nilai',
                'show nilai',

                'form absen',
                'add absen',
                'edit absen',
                'delete absen',
                'show absen',
            ]);
        }

        Guru::create([
            'user_id' => $guru->id,
            'nama' => $guru->name,
            'alamat' => fake()->address(),
        ]);


        // Orangtua
        $orangtua = User::factory()->create([
            'name' => 'orangtua',
            'username' => 'orangtua',
            'email' => 'orangtua@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '6281524269051',
        ]);// Replace 'user' with your actual role name
        if ($role) {
            $orangtua->assignRole($role_orangtua); // Assign 'guru' role to the user
            $orangtua->givePermissionTo([
                'show nilai',
                'show kegiatan',
                'show siswa',
            ]);
        }

        OrangTua::create([
            'user_id' => $orangtua->id,
            'nama' => $orangtua->name,
            'alamat' => fake()->address(),
            'no_telpon' => '031524269051',

        ]);
    }
}
