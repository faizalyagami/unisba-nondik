<?php

namespace Database\Seeders;

use App\Models\Reff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        DB::table('reffs')->insert([
            ['id' => 2, 'name' => 'genders', 'value' => 1, 'show' => 'Laki - laki', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],       
            ['id' => 3, 'name' => 'genders', 'value' => 2, 'show' => 'Perempuan', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],

            ['id' => 4, 'name' => 'religions', 'value' => 1, 'show' => 'Islam', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'religions', 'value' => 2, 'show' => 'Kristen', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'religions', 'value' => 3, 'show' => 'Katholik', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'religions', 'value' => 4, 'show' => 'Hindu', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'religions', 'value' => 5, 'show' => 'Budha', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],

            ['id' => 9, 'name' => 'minimalsks', 'value' => 146, 'show' => '146 SKS', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'rangesks', 'value' => 146, 'show' => 'Cukup', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'rangesks', 'value' => 200, 'show' => 'Baik', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'rangesks', 'value' => 300, 'show' => 'Terpuji', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'tahunajaran', 'value' => 1, 'show' => '2023/2024', 'status' => 1, 'creator' => 'admin', 'editor' => 'admin','created_at' => now(), 'updated_at' => now()],
            
        ]);
    }
}
