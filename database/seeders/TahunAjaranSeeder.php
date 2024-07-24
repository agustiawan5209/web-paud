<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunAjaran::insert([
            ['tahun'=> '2022/2023'],
            ['tahun'=> '2023/2024'],
            ['tahun'=> '2024/2025'],
            ['tahun'=> '2025/2026'],
        ]);
    }
}
