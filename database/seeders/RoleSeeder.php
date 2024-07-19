<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

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

    }
}
