<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sub_activities')->truncate();
        DB::table('activities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data aktivitas utama
        $activities = [
            ['name' => 'Penerimaan Mahasiswa Baru (2 KEGIATAN WAJIB)'],
            ['name' => 'Pelatihan Pengembangan Diri (PPD) Mahasiswa Psikologi (1 KEGIATAN WAJIB)'],
            ['name' => 'Kegiatan Konsultasi Dosen Wali (8 KEGIATAN WAJIB)'],
            ['name' => 'Sosialisasi Profil Lulusan (3 KEGIATAN WAJIB)'],
            ['name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Keilmuan dan Penalaran (1 KEGIATAN WAJIB)'],
            ['name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengembangan Minat dan Bakat (1 KEGIATAN WAJIB)'],
            ['name' => 'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian Kepada Masyarakat (PKM) (1 KEGIATAN WAJIB)'],
            ['name' => 'Program Peningkatan Kompetensi Diri (1 KEGIATAN WAJIB)'],
            ['name' => 'Kegiatan Ruhul Islam (3 KEGIATAN WAJIB)'],
            ['name' => 'Orientasi Kerja (1 KEGIATAN WAJIB)']
        ];

        // Insert aktivitas utama
        $activityIds = [];
        foreach ($activities as $activity) {
            $id = DB::table('activities')->insertGetId([
                'name' => $activity['name'],
                'status' => 1,
                'creator' => 'Seeder',
                'editor' => 'Seeder',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $activityIds[$activity['name']] = $id;
        }

        // Data sub-aktivitas dengan field REQUIRED
        $subActivities = [
            // Penerimaan Mahasiswa Baru
            'Penerimaan Mahasiswa Baru (2 KEGIATAN WAJIB)' => [
                ['name' => 'Taaruf (WAJIB)', 'sks' => 10, 'required' => true, 'notes' => 'Program Pembinaan Mahasiswa Baru'],
                ['name' => 'Program Pembinaan Mahasiswa Baru (WAJIB)', 'sks' => 10, 'required' => true, 'notes' => ''],
            ],

            'Pelatihan Pengembangan Diri (PPD) Mahasiswa Psikologi (1 KEGIATAN WAJIB)' => [
                ['name' => 'Pelatihan Pengembangan Diri (PPD) (WAJIB)', 'sks' => 15, 'required' => true, 'notes' => ''],
            ],

            // Kegiatan Konsultasi Dosen Wali
            'Kegiatan Konsultasi Dosen Wali (8 KEGIATAN WAJIB)' => [
                ['name' => 'Konsultasi Hasil Psikotes, Evaluasi Diri dan Action Plan Semester 1 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Hasil Psikotes, Evaluasi Diri dan Action Plan Semester 2 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Bidang Peminatan, Evaluasi Diri dan Action Plan Semester 3 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Bidang Peminatan, Evaluasi Diri dan Action Plan Semester 4 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi, Evaluasi Diri dan Action Plan Semester 5 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi, Evaluasi Diri dan Action Plan Semester 6 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi dan Rencana Persiapan Karir Setelah Lulus 7 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
                ['name' => 'Konsultasi Perencanaan Penyelesaian Studi dan Rencana Persiapan Karir Setelah Lulus 8 (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => 'OK'],
            ],

            // Sosialisasi Profil Lulusan
            'Sosialisasi Profil Lulusan (3 KEGIATAN WAJIB)' => [
                ['name' => 'Sharing Session 1 pada Semester Ganjil (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => ''],
                ['name' => 'Sharing Session 2 pada Semester Genap (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => ''],
                ['name' => 'Sharing Session 3 pada Semester Ganjil (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => ''],
                ['name' => 'Sharing Session 4 pada Semester Genap (WAJIB)', 'sks' => 4, 'required' => true, 'notes' => ''],
            ],

            // Kegiatan Penunjang Tridharma - Keilmuan dan Penalaran
            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Keilmuan dan Penalaran (1 KEGIATAN WAJIB)' => [
                ['name' => 'Peserta Karya Tulis Lokal (WAJIB)', 'sks' => 8, 'required' => true, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis Regional (WAJIB)', 'sks' => 12, 'required' => true, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis Nasional (WAJIB)', 'sks' => 16, 'required' => true, 'notes' => ''],
                ['name' => 'Peserta Karya Tulis International (WAJIB)', 'sks' => 22, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Lokal (WAJIB)', 'sks' => 15, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Regional (WAJIB)', 'sks' => 20, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Karya Tulis Nasional (WAJIB)', 'sks' => 25, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Karya Tulis International (WAJIB)', 'sks' => 40, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Kategori Karya Tulis Lokal (WAJIB)', 'sks' => 10, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Kategori Karya Tulis Regional (WAJIB)', 'sks' => 15, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Kategori Karya Tulis Nasional (WAJIB)', 'sks' => 20, 'required' => true, 'notes' => ''],
                ['name' => 'Juara Kategori Karya Tulis Internasional (WAJIB)', 'sks' => 30, 'required' => true, 'notes' => ''],
                ['name' => 'Peserta Seminar Lokal (LURING)', 'sks' => 4, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar Regional (LURING)', 'sks' => 6, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar Nasional (LURING)', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar International (LURING)', 'sks' => 14, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar Lokal (DARING)', 'sks' => 3, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar Regional (DARING)', 'sks' => 4, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar Nasional (DARING)', 'sks' => 5, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Seminar International (DARING)', 'sks' => 7, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Lokal (LURING)', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Regional (LURING)', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Nasional (LURING)', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar International (LURING)', 'sks' => 25, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Lokal (DARING)', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Regional (DARING)', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar Nasional (DARING)', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Seminar International (DARING)', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Workshop Lokal', 'sks' => 5, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Workshop Regional', 'sks' => 7, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Workshop Nasional', 'sks' => 12, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Workshop Internasional', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Fasilitator/Moderator Workshop Lokal', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Fasilitator/Moderator Workshop Regional', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Fasilitator/Moderator Workshop Nasional', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Fasilitator/Moderator Workshop Internasional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Workshop Lokal', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Workshop Regional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Workshop Nasional', 'sks' => 25, 'required' => false, 'notes' => ''],
                ['name' => 'Pemateri Workshop Internasional', 'sks' => 30, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Keilmuan Lokal', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Keilmuan Regional', 'sks' => 12, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Keilmuan Nasional', 'sks' => 16, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Keilmuan Internasional', 'sks' => 22, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Lokal', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Regional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Nasional', 'sks' => 25, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Internasional', 'sks' => 40, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Lokal', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Regional', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Nasional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Keilmuan Internasional', 'sks' => 30, 'required' => false, 'notes' => ''],
                ['name' => 'Anggota Peneliti Tim Dosen', 'sks' => 10, 'required' => false, 'notes' => ''],
            ],

            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengembangan Minat dan Bakat (1 KEGIATAN WAJIB)' => [
                ['name' => 'Top Management DAMF, BEMF, DAMU, BEMU (WAJIB)', 'sks' => 45, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management DAMF, BEMF, DAMU, BEMU (WAJIB)', 'sks' => 35, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan DAMF, BEMF, DAMU, BEMU (WAJIB)', 'sks' => 25, 'required' => true, 'notes' => ''],
                ['name' => 'Top Management LLKM dan UKM (Bompai, Pasuma, Protokoler, dll) (WAJIB)', 'sks' => 25, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management LLKM dan UKM (Bompai, Pasuma, Protokoler, dll) (WAJIB)', 'sks' => 20, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan LLKM dan UKM (Bompai, Pasuma, Protokoler, dll) (WAJIB)', 'sks' => 15, 'required' => true, 'notes' => ''],
                ['name' => 'Anggota LKM dan UKM (Bompai, Pasuma, Protokoler, dll)', 'sks' => 3, 'required' => false, 'notes' => ''],
                ['name' => 'Top Management UPM-F (Psychobasern KBU, Kajian Sinema, dll) (WAJIB)', 'sks' => 25, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management UPM-F (Psychobasern KBU, Kajian Sinema, dll) (WAJIB)', 'sks' => 20, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan UPM-F (Psychobasern KBU, Kajian Sinema, dll) (WAJIB)', 'sks' => 12, 'required' => true, 'notes' => ''],
                ['name' => 'Anggota UPM-F (Psychobascm KBU, Kajian Sinema, dll)', 'sks' => 3, 'required' => false, 'notes' => ''],
                ['name' => 'Top Management PANSUS SKS Non Akademik (WAJIB)', 'sks' => 45, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management PANSUS SKS Non Akademik (WAJIB)', 'sks' => 35, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan PANSUS SKS Non Akademik (WAJIB)', 'sks' => 25, 'required' => true, 'notes' => ''],
                ['name' => 'Top Management Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Middle Management Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Imamupsi, HMI, Kemahpsibaraya, dll', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Top Management Karang Taruna, dll', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Middle Management Karang Taruna, dll', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Karang Taruna, dll', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Minat dan Bakat Lokal', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Minat dan Bakat Regional', 'sks' => 12, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Minat dan Bakat Nasional', 'sks' => 16, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Perlombaan Dalam Bidang Minat dan Bakat Internasional', 'sks' => 22, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Lokal', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Regional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Nasional', 'sks' => 25, 'required' => false, 'notes' => ''],
                ['name' => 'Juara 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Internasional', 'sks' => 40, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Lokal', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Regional', 'sks' => 15, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Nasional', 'sks' => 20, 'required' => false, 'notes' => ''],
                ['name' => 'Juara Harapan 1, 2 dan 3 Perlombaan Dalam Bidang Minat dan Bakat Internasional', 'sks' => 30, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta/Pengisi Acara/MC Kegiatan/Pagelaran/Pertunjukan Seni', 'sks' => 5, 'required' => false, 'notes' => ''],
                ['name' => 'Host/MC/Moderator/Presidium Lokal/Regional', 'sks' => 4, 'required' => false, 'notes' => ''],
                ['name' => 'Host/MC/Moderator/Presidium Nasional', 'sks' => 7, 'required' => false, 'notes' => ''],
                ['name' => 'Host/MC/Moderator/Presidium Internasional', 'sks' => 10, 'required' => false, 'notes' => ''],
            ],

            // Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian kepada Masyarakat
            'Kegiatan Penunjang Tridharma Perguruan Tinggi Bidang Pengabdian Kepada Masyarakat (PKM) (1 KEGIATAN WAJIB)' => [
                ['name' => 'Relawan/Volunteer Kegiatan Kemasyarakatan (Bakti Sosial) < 2 minggu', 'sks' => 6, 'required' => false, 'notes' => ''],
                ['name' => 'Relawan/Volunteer Kegiatan Kemasyarakatan (Bakti Sosial) > 2 minggu', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Top Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) 1 Batch (WAJIB)', 'sks' => 13, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) 1 Batch (WAJIB)', 'sks' => 10, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) 1 Batch (WAJIB)', 'sks' => 7, 'required' => true, 'notes' => ''],
                ['name' => 'Top Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) 1 Batch (WAJIB)', 'sks' => 15, 'required' => true, 'notes' => ''],
                ['name' => 'Middle Management Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) 1 Batch (WAJIB)', 'sks' => 12, 'required' => true, 'notes' => ''],
                ['name' => 'Pelaksana Lapangan Kepanitiaan (PAKEM, Ekstraloba, Rumah Belajar Taman Sari, dll) > 1 Batch (WAJIB)', 'sks' => 9, 'required' => true, 'notes' => ''],
                ['name' => 'Anggota Tim Pengabdian Masyarakat Dosen', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Tester/Scorer/Observer/Interviewer', 'sks' => 5, 'required' => false, 'notes' => ''],
                ['name' => 'Asisten Laboratorium Psikologi', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Aplikasi Ilmu Psikologi < 1 Bulan', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Aplikasi Ilmu Psikologi > 1 Bulan-3 Bulan', 'sks' => 12, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Aplikasi Ilmu Psikologi > 3 Bulan', 'sks' => 16, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Bidang non Psikologi < 1 Bulan', 'sks' => 5, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Bidang non Psikologi > 1-3 Bulan', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Melakukan Magang Kerja Dalam Bidang non Psikologi > 3 Bulan', 'sks' => 12, 'required' => false, 'notes' => ''],
            ],


            // Program Peningkatan Kompetensi Diri
            'Program Peningkatan Kompetensi Diri (1 KEGIATAN WAJIB)' => [
                ['name' => 'Test Bahasa Inggris (TOEFL/IELTS/TOEIC/TOEP/dsb)', 'sks' => 15, 'required' => true, 'notes' => ''],
                ['name' => 'Test Bahasa Asing Lain (Mandarin, Arab, Jerman, Perancis, dsb)', 'sks' => 8, 'required' => false, 'notes' => ''],
                ['name' => 'Sertifikat Kompetensi Kerja', 'sks' => 10, 'required' => false, 'notes' => ''],
            ],

            // Kegiatan Rohani Islam
            'Kegiatan Ruhul Islam (3 KEGIATAN WAJIB)' => [
                ['name' => 'PJM Unisba (WAJIB)', 'sks' => 5, 'required' => true, 'notes' => ''],
                ['name' => 'BTAQ Universitas (WAJIB)', 'sks' => 10, 'required' => true, 'notes' => ''],
                ['name' => 'BTAQ Fakultas (WAJIB)', 'sks' => 12, 'required' => true, 'notes' => ''],
                ['name' => 'Mengisi Acara Kegiatan Keislaman', 'sks' => 10, 'required' => false, 'notes' => ''],
                ['name' => 'Peserta Kegiatan Peningkatan Iman dan Taqwa', 'sks' => 3, 'required' => false, 'notes' => ''],
                ['name' => 'Panitia Kegiatan Peningkatan Iman dan Taqwa', 'sks' => 5, 'required' => false, 'notes' => ''],
            ],

            // Orientasi Kerja
            'Orientasi Kerja (1 KEGIATAN WAJIB)' => [
                ['name' => 'Penyusunan Laporan Orientasi Kerja sesuai Bidang Peminatan', 'sks' => 7, 'required' => true, 'notes' => ''],
            ]
        ];

        // Insert sub-aktivitas dengan field required
        foreach ($subActivities as $activityName => $subs) {
            $activityId = $activityIds[$activityName];

            foreach ($subs as $sub) {
                DB::table('sub_activities')->insert([
                    'activity_id' => $activityId,
                    'name' => $sub['name'],
                    'sks' => $sub['sks'],
                    'required' => $sub['required'], // Field baru
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
    }
}
