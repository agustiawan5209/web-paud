<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kelas Permission
        Permission::create(['name' => 'add kelas']);
        Permission::create(['name' => 'edit kelas']);
        Permission::create(['name' => 'delete kelas']);
        Permission::create(['name' => 'show kelas']);

        // guru Permission
        Permission::create(['name' => 'add guru']);
        Permission::create(['name' => 'edit guru']);
        Permission::create(['name' => 'delete guru']);
        Permission::create(['name' => 'show guru']);
        Permission::create(['name' => 'reset guru']);


        // orangtua Permission
        Permission::create(['name' => 'add orangtua']);
        Permission::create(['name' => 'edit orangtua']);
        Permission::create(['name' => 'delete orangtua']);
        Permission::create(['name' => 'show orangtua']);
        Permission::create(['name' => 'reset orangtua']);
        // siswa Permission
        Permission::create(['name' => 'add siswa']);
        Permission::create(['name' => 'edit siswa']);
        Permission::create(['name' => 'delete siswa']);
        Permission::create(['name' => 'show siswa']);
        Permission::create(['name' => 'reset siswa']);
        // kegiatan Permission
        Permission::create(['name' => 'add kegiatan']);
        Permission::create(['name' => 'edit kegiatan']);
        Permission::create(['name' => 'delete kegiatan']);
        Permission::create(['name' => 'show kegiatan']);
        // nilai Permission
        Permission::create(['name' => 'add nilai']);
        Permission::create(['name' => 'edit nilai']);
        Permission::create(['name' => 'delete nilai']);
        Permission::create(['name' => 'show nilai']);
        Permission::create(['name' => 'cetak nilai']);


        Permission::create(['name' => 'add absen']);
        Permission::create(['name' => 'edit absen']);
        Permission::create(['name' => 'delete absen']);
        Permission::create(['name' => 'show absen']);
        Permission::create(['name' => 'cetak absen']);
    }
}
