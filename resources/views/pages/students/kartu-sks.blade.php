<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu SKS Non-Akademik - {{ $student->name }}</title>
    <style>
        /* CSS untuk kartu SKS */
        @page { margin: 15mm; }
        body { font-family: 'Arial', sans-serif; font-size: 10pt; line-height: 1.3; color: #000; }
        
        .header { text-align: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #000; }
        .header h1 { font-size: 14pt; margin: 5px 0; font-weight: bold; }
        .header h2 { font-size: 12pt; margin: 3px 0; }
        .header h3 { font-size: 11pt; margin: 3px 0; font-weight: bold; }
        
        .student-info { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .student-info td { padding: 4px 8px; border: 1px solid #000; vertical-align: top; }
        .student-info td:first-child { width: 30%; font-weight: bold; background-color: #f5f5f5; }
        
        .status-terpenuhi { color: #006400; font-weight: bold; }
        .status-belum { color: #8B0000; font-weight: bold; }
        
        .requirements-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 9pt; }
        .requirements-table th, .requirements-table td { border: 1px solid #000; padding: 4px; text-align: left; vertical-align: top; }
        .requirements-table th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        
        .kegiatan-section { margin-bottom: 15px; page-break-inside: avoid; }
        .kegiatan-section h4 { font-size: 10pt; font-weight: bold; margin: 8px 0 5px 0; padding: 3px; background-color: #e8e8e8; border-left: 3px solid #333; }
        
        .kegiatan-table { width: 100%; border-collapse: collapse; font-size: 9pt; }
        .kegiatan-table td { padding: 3px 5px; border: 1px solid #ccc; }
        
        .page-break { page-break-before: always; }
        .no-print { display: none; }
        
        @media screen {
            .no-print { display: block; }
        }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>PANITIA KHUSUS (PANSUS) FAKULTAS PSIKOLOGI</h1>
        <h2>UNIVERSITAS ISLAM BANDUNG</h2>
        <h3>2025-2026</h3>
        <h2>KARTU SKS NON AKADEMIK (ANGKATAN {{ $student->class_of }})</h2>
    </div>
    
    <!-- Info Mahasiswa -->
    <table class="student-info">
        <tr>
            <td>NAMA</td>
            <td>{{ $student->name }}</td>
        </tr>
        <tr>
            <td>NPM</td>
            <td>{{ $student->npm }}</td>
        </tr>
        <tr>
            <td>ANGKATAN</td>
            <td>{{ $student->class_of }}</td>
        </tr>
        <tr>
            <td>PENGUMPULAN MELALUI</td>
            <td>WEBSITE</td>
        </tr>
        <tr>
            <td>STATUS SKS NON AKADEMIK</td>
            <td class="{{ ($totalSks >= $minimalSks) && $kegiatanWajibSemuaTerpenuhi ? 'status-terpenuhi' : 'status-belum' }}">
                {{ ($totalSks >= $minimalSks) && $kegiatanWajibSemuaTerpenuhi ? 'LULUS' : 'BELUM LULUS' }}
            </td>
        </tr>
    </table>
    
    <!-- Syarat Pengajuan Sertifikat -->
    <h3>SYARAT PENGAJUAN SERTIFIKAT</h3>
    <table class="requirements-table">
        <thead>
            <tr>
                <th width="5%">NO.</th>
                <th width="45%">SYARAT PENGAJUAN SERTIFIKAT</th>
                <th width="15%">STATUS</th>
                <th width="20%">KETERANGAN</th>
                <th width="15%">PENGUMPULAN</th>
            </tr>
        </thead>
        <tbody>
            <!-- Syarat 1: Skor Minimal -->
            <tr>
                <td>1</td>
                <td>MENCAPAI SKOR MINIMAL KELULUSAN SKS NON-AKADEMIK</td>
                <td class="{{ $totalSks >= $minimalSks ? 'status-terpenuhi' : 'status-belum' }}">
                    {{ $totalSks >= $minimalSks ? 'TERPENUHI' : 'BELUM TERPENUHI' }}
                </td>
                <td>{{ $totalSks }} SKS</td>
                <td>WEBSITE</td>
            </tr>
            
            <!-- Syarat 2: Kegiatan Wajib -->
            <tr>
                <td>2</td>
                <td>MENGIKUTI SELURUH KEGIATAN YANG WAJIB DIIKUTI</td>
                <td class="{{ $kegiatanWajibSemuaTerpenuhi ? 'status-terpenuhi' : 'status-belum' }}">
                    {{ $kegiatanWajibSemuaTerpenuhi ? 'TERPENUHI' : 'BELUM TERPENUHI' }}
                </td>
                <td>{{ $jumlahKegiatanWajibTerpenuhi }}/{{ $totalKegiatanWajib }} kegiatan</td>
                <td>WEBSITE</td>
            </tr>
        </tbody>
    </table>
    
    <!-- Detail Kegiatan -->
    @foreach($kegiatanKelompok as $kelompok)
        <div class="kegiatan-section">
            <h4>{{ strtoupper($kelompok['nama']) }}</h4>
            <table class="kegiatan-table">
                @foreach($kelompok['kegiatan'] as $index => $kegiatan)
                    @php
                        // Cek apakah kegiatan ini WAJIB
                        $isWajib = str_contains($kegiatan['nama'], '(WAJIB)');
                        $statusClass = $kegiatan['status'] == 'TERPENUHI' ? 'status-terpenuhi' : 'status-belum';
                    @endphp
                    <tr>
                        <td width="70%">
                            {{ $index + 1 }}. {{ $kegiatan['nama'] }}
                            @if($isWajib) <strong>(WAJIB)</strong> @endif
                        </td>
                        <td width="15%" class="{{ $statusClass }}">
                            {{ $kegiatan['status'] }}
                        </td>
                        <td width="15%">
                            @if($kegiatan['status'] == 'TERPENUHI')
                                {{ $kegiatan['sks'] }} SKS
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
    
    <!-- Ringkasan -->
    <div style="margin-top: 20px; padding: 10px; border: 1px solid #000; background-color: #f9f9f9;">
        <h4>RINGKASAN PENCAPAIAN</h4>
        <table style="width: 100%;">
            <tr>
                <td width="70%"><strong>Total SKS yang Diperoleh:</strong></td>
                <td width="30%"><strong>{{ $totalSks }} SKS</strong></td>
            </tr>
            <tr>
                <td>Minimal SKS yang Diperlukan:</td>
                <td>{{ $minimalSks }} SKS</td>
            </tr>
            <tr>
                <td>Kegiatan Wajib yang Telah Terpenuhi:</td>
                <td>{{ $jumlahKegiatanWajibTerpenuhi }}/{{ $totalKegiatanWajib }}</td>
            </tr>
            <tr>
                <td><strong>Status Kelulusan:</strong></td>
                <td class="{{ ($totalSks >= $minimalSks) && $kegiatanWajibSemuaTerpenuhi ? 'status-terpenuhi' : 'status-belum' }}">
                    <strong>{{ ($totalSks >= $minimalSks) && $kegiatanWajibSemuaTerpenuhi ? 'LULUS' : 'BELUM LULUS' }}</strong>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Tombol Aksi (hanya tampil di web) -->
    <div class="no-print" style="margin-top: 20px; text-align: center; padding: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; margin: 5px;">
            🖨️ Cetak Kartu SKS
        </button>
        <a href="{{ route('student.kartu-sks.pdf', $student->id) }}" style="padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">
            📥 Download PDF
        </a>
        <br><br>
        <small style="color: #666;">Dokumen ini dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</small>
    </div>
</body>
</html>