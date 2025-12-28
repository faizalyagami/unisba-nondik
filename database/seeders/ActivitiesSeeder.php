<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
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
        DB::table('sub_activities')->truncate();
        DB::table('activities')->truncate();

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data aktivitas utama (yang bold)
        $activities = [
            [
                'name' => 'Penerimaan Mahasiswa Baru',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Pelatihan Pengembangan Diri (PPU) Mahasiswa Psikologi',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Kegiatan Konsultasi Dosen Wali',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Sosialisasi Profil Lulusan',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Keilmuan dan Penalaran',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengembangan Minat dan Bakat',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian kepada Masyarakat',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Program Peningkatan Kompetensi Diri',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Kegiatan Rohani Islam',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ],
            [
                'name' => 'Orientasi Kerja',
                'creator' => 'Seeder',
                'editor' => 'Seeder'
            ]
        ];

        // Insert aktivitas utama dan simpan ID-nya
        $activityIds = [];
        foreach ($activities as $activity) {
            $id = DB::table('activities')->insertGetId([
                'name' => $activity['name'],
                'status' => 1,
                'creator' => $activity['creator'],
                'editor' => $activity['editor'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $activityIds[$activity['name']] = $id;
        }

        // Data sub-aktivitas
        $subActivities = [
            // Penerimaan Mahasiswa Baru
            'Penerimaan Mahasiswa Baru' => [
                ['name' => 'Taaruf (WAJIB)', 'sks' => 8, 'notes' => 'Program Pembinaan Mahasiswa Baru'],
                ['name' => 'Program Pembinaan Mahasiswa Baru (WAJIB)', 'sks' => 0, 'notes' => ''],
            ],

            // Kegiatan Konsultasi Dosen Wali
            'Kegiatan Konsultasi Dosen Wali' => [
                ['name' => 'Konsultasi Hasil Psikotes, Evaluasi Diri dan Action Plan Semester 1 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Hasil Psikotes, Evaluasi Diri dan Action Plan Semester 2 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Bidang Peminatan, Evaluasi Diri dan Action Plan Semester 3 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Bidang Peminatan, Evaluasi Diri dan Action Plan Semester 4 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi, Evaluasi Diri dan Action Plan Semester 5 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi, Evaluasi Diri dan Action Plan Semester 6 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi dan Rencana Persiapan Karir Setelah Lulus 7 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi dan Rencana Persiapan Karir Setelah Lulus 8 (WAJIB)', 'sks' => 3, 'notes' => 'OK'],
            ],

            // Sosialisasi Profil Lulusan
            'Sosialisasi Profil Lulusan' => [
                ['name' => 'Sharing Session 1 pada Semester Ganjil', 'sks' => 6, 'notes' => ''],
                ['name' => 'Sharing Session 2 pada Semester Genap', 'sks' => 4, 'notes' => ''],
                ['name' => 'Sharing Session 3 pada Semester Ganjil', 'sks' => 6, 'notes' => ''],
                ['name' => 'Sharing Session 4 pada Semester Genap', 'sks' => 4, 'notes' => ''],
            ],

            // Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Keilmuan dan Penalaran
            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Keilmuan dan Penalaran' => [
                ['name' => 'Peserta Karya Tulis Lokal', 'sks' => 12, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis Regional', 'sks' => 15, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis Nasional', 'sks' => 22, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis International', 'sks' => 27, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Lokal', 'sks' => 18, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Regional', 'sks' => 25, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Nasional', 'sks' => 27, 'notes' => ''],
                ['name' => 'Juara Karya Tulis International', 'sks' => 32, 'notes' => ''],
                ['name' => 'Peserta Seminar Lokal', 'sks' => 3, 'notes' => ''],
                ['name' => 'Peserta Seminar Regional', 'sks' => 5, 'notes' => ''],
                ['name' => 'Peserta Seminar Nasional', 'sks' => 10, 'notes' => ''],
                ['name' => 'Peserta Seminar International', 'sks' => 15, 'notes' => ''],
                ['name' => 'Pemateri Seminar Lokal', 'sks' => 8, 'notes' => ''],
                ['name' => 'Pemateri Seminar Regional', 'sks' => 10, 'notes' => ''],
                ['name' => 'Pemateri Seminar Nasional', 'sks' => 15, 'notes' => ''],
                ['name' => 'Pemateri Seminar International', 'sks' => 20, 'notes' => ''],
                ['name' => 'Peserta Workshop', 'sks' => 5, 'notes' => ''],
                ['name' => 'Fasilitator/Moderator Workshop', 'sks' => 8, 'notes' => ''],
                ['name' => 'Pemateri Workshop', 'sks' => 10, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Keilmuan', 'sks' => 12, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan', 'sks' => 18, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan', 'sks' => 15, 'notes' => ''],
                ['name' => 'Anggota Peneliti Tim Dosen', 'sks' => 15, 'notes' => ''],
            ],

            // Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengembangan Minat dan Bakat
            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengembangan Minat dan Bakat' => [
                ['name' => 'Top Management DAMF, BEMF, DAMU, BEMU', 'sks' => 18, 'notes' => ''],
                ['name' => 'Middle Management DAMF, BEMF, DAMU, BEMU', 'sks' => 12, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan DAMF, BEMF, DAMU, BEMU', 'sks' => 7, 'notes' => ''],
                ['name' => 'Top Management LLKM dan UKM (Bompai, Pasuma, Protokoler, dll)', 'sks' => 15, 'notes' => ''],
                ['name' => 'Middle Management LLKM dan UKM (Bompai, Pasuma, Protokoler, dll)', 'sks' => 12, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan LLKM dan UKM (Bompai, Pasuma, Protokoler, dll)', 'sks' => 7, 'notes' => ''],
                ['name' => 'Top Management UPM-F (Psychobasern KBU, Kajian Sinema, dll)', 'sks' => 15, 'notes' => ''],
                ['name' => 'Middle Management UPM-F (Psychobasern KBU, Kajian Sinema, dll)', 'sks' => 12, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan UPM-F (Psychobasern KBU, Kajian Sinema, dll)', 'sks' => 7, 'notes' => ''],
                ['name' => 'Top Management PAINSUS SKS Non Akademik', 'sks' => 18, 'notes' => ''],
                ['name' => 'Middle Management PAINSUS SKS Non Akademik', 'sks' => 15, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan PAINSUS SKS Non Akademik', 'sks' => 0, 'notes' => ''],
                ['name' => 'Top Management Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 15, 'notes' => ''],
                ['name' => 'Middle Management Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 9, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 7, 'notes' => ''],
                ['name' => 'Top Management Karang Taruna, dll', 'sks' => 15, 'notes' => ''],
                ['name' => 'Middle Management Karang Taruna, dll', 'sks' => 9, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Karang Taruna, dll', 'sks' => 7, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Minat dan Bakat', 'sks' => 10, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat', 'sks' => 15, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat', 'sks' => 12, 'notes' => ''],
                ['name' => 'Peserta/Pengisi Acara/MC Kegiatan/Pagelaran/Pertunjukan Seni', 'sks' => 3, 'notes' => ''],
            ],

            // Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian kepada Masyarakat
            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian kepada Masyarakat' => [
                ['name' => 'Relawan/Volunteer Kegiatan Kemasyarakatan (Bakti Sosial)', 'sks' => 6, 'notes' => ''],
                ['name' => 'Top Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll)', 'sks' => 8, 'notes' => ''],
                ['name' => 'Middle Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll)', 'sks' => 6, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll)', 'sks' => 3, 'notes' => ''],
                ['name' => 'Anggota Tim Pengabdian Masyarakat Dosen', 'sks' => 15, 'notes' => ''],
                ['name' => 'Tester/Scorer/Observer/Interviewer', 'sks' => 3, 'notes' => ''],
                ['name' => 'Asisten Laboratorium Psikologi', 'sks' => 10, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Aplikasi Ilmu Psikologi', 'sks' => 5, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Bidang non Psikologi', 'sks' => 3, 'notes' => ''],
            ],

            // Program Peningkatan Kompetensi Diri
            'Program Peningkatan Kompetensi Diri' => [
                ['name' => 'Test Bahasa Inggris (TOEFL/IELTS/TOEIC/TOEP/dsb)', 'sks' => 15, 'notes' => ''],
                ['name' => 'Test Bahasa Asing Lain (Mandarin, Arab, Jerman, Perancis, dsb)', 'sks' => 8, 'notes' => ''],
                ['name' => 'Sertifikat Kompetensi Kerja', 'sks' => 10, 'notes' => ''],
            ],

            // Kegiatan Rohani Islam
            'Kegiatan Rohani Islam' => [
                ['name' => 'PJM Unisba', 'sks' => 5, 'notes' => ''],
                ['name' => 'BTAG Universitas', 'sks' => 10, 'notes' => ''],
                ['name' => 'BTAG Fakultas', 'sks' => 12, 'notes' => ''],
                ['name' => 'Mengisi Acara Kegiatan Keislaman', 'sks' => 10, 'notes' => ''],
                ['name' => 'Peserta Kegiatan Peningkatan Iman dan Taqwa', 'sks' => 3, 'notes' => ''],
                ['name' => 'Panitia Kegiatan Peningkatan Iman dan Taqwa', 'sks' => 5, 'notes' => ''],
            ],

            // Orientasi Kerja
            'Orientasi Kerja' => [
                ['name' => 'Penyusunan Laporan Orientasi Kerja sesuai Bidang Peminatan', 'sks' => 7, 'notes' => ''],
            ]
        ];

        // Insert sub-aktivitas
        foreach ($subActivities as $activityName => $subs) {
            $activityId = $activityIds[$activityName];

            foreach ($subs as $sub) {
                DB::table('sub_activities')->insert([
                    'activity_id' => $activityId,
                    'name' => $sub['name'],
                    'sks' => $sub['sks'],
                    'notes' => $sub['notes'],
                    'status' => 1,
                    'creator' => 'Seeder',
                    'editor' => 'Seeder',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->command->info('Activities and Sub Activities seeded successfully!');
        $this->command->info('Total Activities: ' . count($activities));

        $totalSubs = 0;
        foreach ($subActivities as $subs) {
            $totalSubs += count($subs);
        }
        $this->command->info('Total Sub Activities: ' . $totalSubs);
    }
}
