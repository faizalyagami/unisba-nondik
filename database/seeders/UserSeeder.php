<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel terlebih dahulu
        DB::table('users')->truncate();

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Pertama, kita perlu membuat data students terlebih dahulu
        // atau mengasumsikan student_id mengacu pada id di tabel students

        // Data users - student_id mengacu pada id di tabel students, bukan NPM
        $users = [
            // Admin - Faisal (bukan mahasiswa, jadi student_id = 0/null)
            [
                'student_id' => 0, // atau null, karena admin bukan mahasiswa
                'name' => 'Faisal',
                'username' => 'A210472',
                'email' => 'faizalyagami@gmail.com',
                'password' => Hash::make('password'),
                'level' => 1, // admin
                'status' => 1,
                'creator' => 'Seeder',
                'editor' => 'Seeder',
                'email_verified_at' => now(),
            ],
            [
                'student_id' => 0, // bukan mahasiswa
                'name' => 'Suhana',
                'username' => 'D000329',
                'email' => 'suhana@example.com',
                'password' => Hash::make('password'),
                'level' => 4,
                'status' => 1,
                'creator' => 'Seeder',
                'editor' => 'Seeder',
                'email_verified_at' => now(),
            ],
        ];

        // Insert users
        foreach ($users as $user) {
            DB::table('users')->insert([
                'student_id' => $user['student_id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => $user['password'],
                'remember_token' => null,
                'level' => $user['level'],
                'status' => $user['status'],
                'creator' => $user['creator'],
                'editor' => $user['editor'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Total users: ' . count($users));
    }
}
