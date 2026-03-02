<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periods')->insert([
            [
                'name' => '2025/2026 Semester Ganjil',
                'tahun_awal' => 2025,
                'tahun_akhir' => 2026,
                'semester' => 'ganjil',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '2025/2026 Semester Genap',
                'tahun_awal' => 2025,
                'tahun_akhir' => 2026,
                'semester' => 'genap',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '2024/2025 Semester Ganjil',
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025,
                'semester' => 'ganjil',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '2024/2025 Semester Genap',
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025,
                'semester' => 'genap',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '2024/2025 Semester Antara',
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025,
                'semester' => 'antara',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
