<?php

namespace Database\Seeders;

use App\Models\Guru;
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
        $orangtua = Role::create(['name' => 'Orang Tua']);
        $guru = Role::create(['name' => 'Guru']);



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
            $user->assignRole($role); // Assign 'user' role to the user
            $user->givePermissionTo([
                'add nilai',
                'edit nilai',
                'delete nilai',
                'show nilai',
            ]);
        }

        Guru::create([
            'user_id' => $guru->id,
            'nama' => $guru->name,
            'alamat' => fake()->address(),
        ]);
    }
}
