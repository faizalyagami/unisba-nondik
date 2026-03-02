<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu SKS Non-Akademik - {{ $student->name }}</title>
    <style>
        /* CSS untuk kartu SKS */
        @page {
            margin: 15mm;
            size: A4 portrait;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .page {
            width: 190mm;
            min-height: 267mm;
            padding: 10mm;
            page-break-after: always;
            box-sizing: border-box;
            margin: 0 auto;
            background-color: #fff;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .content {
            width: 100%;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .logo-container {
            width: 60px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .logo-img {
            width: 50px;
            height: auto;
            display: block;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #666;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-title {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
        }

        .header-subtitle {
            margin: 2px 0;
            font-size: 10pt;
        }

        .header-year {
            margin: 2px 0;
            font-size: 9pt;
            font-weight: bold;
        }

        .header-card-title {
            margin-top: 5px;
            font-size: 10pt;
            font-weight: bold;
        }

        /* INFO MAHASISWA */
        .student-info {
            width: 100%;
            margin: 0 auto 12px auto;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 9pt;
        }

        .student-info td {
            padding: 4px 8px;
            border: 1px solid #000;
            vertical-align: middle;
        }

        .student-info td:first-child {
            width: 35%;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        /* STATUS */
        .status-terpenuhi {
            color: #006400;
            font-weight: bold;
        }

        .status-belum {
            color: #8B0000;
            font-weight: bold;
        }

        .status-lulus {
            color: #006400;
            font-weight: bold;
            background-color: #d4edda;
            padding: 2px 6px;
            border-radius: 10px;
            display: inline-block;
        }

        .status-belum-lulus {
            color: #8B0000;
            font-weight: bold;
            background-color: #f8d7da;
            padding: 2px 6px;
            border-radius: 10px;
            display: inline-block;
        }

        /* PROGRESS BAR */
        .progress-container {
            width: 100%;
            margin: 12px auto;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .progress-item {
            margin-bottom: 8px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 8pt;
            margin-bottom: 2px;
        }

        .progress-bar-bg {
            width: 100%;
            height: 10px;
            background-color: #dee2e6;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 10px;
            background-color: #28a745;
            border-radius: 5px;
        }

        .progress-bar-fill-blue {
            height: 10px;
            background-color: #007bff;
            border-radius: 5px;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            margin: 15px 0 8px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #000;
        }

        /* TABEL SYARAT */
        .requirements-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto 12px auto;
            font-size: 8pt;
        }

        .requirements-table th,
        .requirements-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
            vertical-align: middle;
        }

        .requirements-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        /* KEGIATAN SECTION */
        .kegiatan-section {
            width: 100%;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .kegiatan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0 6px 0;
            padding: 6px 10px;
            background-color: #e9ecef;
            border-left: 4px solid #333;
            border-radius: 3px;
        }

        .kegiatan-header h4 {
            margin: 0;
            font-size: 9pt;
            font-weight: bold;
        }

        .min-wajib-badge {
            font-size: 7pt;
            background-color: #ffd700;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: normal;
        }

        .kegiatan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }

        .kegiatan-table td {
            padding: 4px 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        /* BADGE */
        .badge-wajib {
            background-color: #ffd700;
            color: #000;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 6pt;
            font-weight: bold;
            display: inline-block;
            margin-left: 3px;
        }

        .badge-terpenuhi {
            background-color: #d4edda;
            color: #155724;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 7pt;
            display: inline-block;
        }

        .badge-belum {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 7pt;
            display: inline-block;
        }

        /* LEGENDA */
        .legend {
            width: 100%;
            margin: 12px auto;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            font-size: 7pt;
            text-align: center;
        }

        .legend-item {
            display: inline-block;
            margin: 0 10px;
        }

        .legend-color {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 2px;
            margin-right: 3px;
            vertical-align: middle;
        }

        /* RINGKASAN */
        .ringkasan-section {
            width: 100%;
            margin: 15px auto;
            padding: 12px;
            border: 1px solid #000;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .ringkasan-table {
            width: 100%;
            font-size: 9pt;
        }

        .ringkasan-table td {
            padding: 4px 0;
        }

        .ringkasan-table tr:last-child td {
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
            font-weight: bold;
        }

        /* RINGKASAN PER KATEGORI */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin: 12px auto;
        }

        .summary-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .summary-table td {
            border: 1px solid #000;
            padding: 4px 6px;
        }

        /* CATATAN */
        .notes {
            width: 100%;
            margin: 12px auto;
            padding: 8px 12px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 5px;
            font-size: 7pt;
            box-sizing: border-box;
        }

        .notes ul {
            margin: 3px 0 0 15px;
            padding: 0;
        }

        /* QR CODE */
        .qr-container {
            text-align: right;
            margin-top: 15px;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
        }

        .qr-placeholder {
            width: 60px;
            height: 60px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6pt;
            margin-left: auto;
        }

        /* TOMBOL */
        .action-buttons {
            margin-top: 25px;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #dee2e6;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 9pt;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin: 5px 8px;
        }

        .btn-print {
            background-color: #28a745;
            color: white;
        }

        .btn-pdf {
            background-color: #dc3545;
            color: white;
        }

        .timestamp {
            margin-top: 8px;
            color: #6c757d;
            font-size: 7pt;
        }

        .no-print {
            display: block;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- HALAMAN 1 -->
    <div class="page">
        <div class="content">
            <!-- Header dengan Logo -->
            <div class="header">
                <div class="logo-container">
                    @php
                    $logoPath = public_path('assets/images/profile/logo-pansus.png');
                    @endphp
                    @if(file_exists($logoPath))
                    <img src="{{ asset('assets/images/profile/logo-pansus.png') }}"
                        class="logo-img"
                        alt="Logo PanSus">
                    @else
                    <div class="logo-placeholder">LOGO</div>
                    @endif
                </div>
                <div class="header-text">
                    <h1 class="header-title">PANITIA KHUSUS (PANSUS) FAKULTAS PSIKOLOGI</h1>
                    <h2 class="header-subtitle">UNIVERSITAS ISLAM BANDUNG</h2>
                    <h3 class="header-year">T.A 2025-2026</h3>
                    <h2 class="header-card-title">KARTU SKS NON AKADEMIK (ANGKATAN {{ $student->class_of }})</h2>
                </div>
            </div>

            <!-- Info Mahasiswa -->
            <table class="student-info">
                <tr>
                    <td>NAMA</td>
                    <td><strong>{{ $student->name }}</strong></td>
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
                    <td>
                        @php
                        $isLulus = ($totalSks >= $minimalSks) && $kegiatanWajibSemuaTerpenuhi;
                        @endphp
                        <span class="{{ $isLulus ? 'status-lulus' : 'status-belum-lulus' }}">
                            {{ $isLulus ? 'LULUS' : 'BELUM LULUS' }}
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-item">
                    <div class="progress-label">
                        <span><strong>Progress SKS</strong></span>
                        <span>{{ $totalSks }}/{{ $minimalSks }} SKS ({{ round(($totalSks / $minimalSks) * 100) }}%)</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ min(($totalSks / $minimalSks) * 100, 100) }}%;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-label">
                        <span><strong>Progress Kegiatan Wajib</strong></span>
                        <span>{{ $jumlahKegiatanWajibTerpenuhi }}/{{ $totalKegiatanWajib }} kegiatan ({{ $totalKegiatanWajib > 0 ? round(($jumlahKegiatanWajibTerpenuhi / $totalKegiatanWajib) * 100) : 0 }}%)</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill-blue" style="width: {{ $totalKegiatanWajib > 0 ? ($jumlahKegiatanWajibTerpenuhi / $totalKegiatanWajib) * 100 : 0 }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Syarat Pengajuan Sertifikat -->
            <h3 class="section-title">SYARAT PENGAJUAN SERTIFIKAT</h3>
            <table class="requirements-table">
                <thead>
                    <tr>
                        <th style="width:5%">NO.</th>
                        <th style="width:40%">SYARAT PENGAJUAN SERTIFIKAT</th>
                        <th style="width:15%">STATUS</th>
                        <th style="width:20%">KETERANGAN</th>
                        <th style="width:15%">PENGUMPULAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center">1</td>
                        <td>MENCAPAI SKOR MINIMAL KELULUSAN SKS NON-AKADEMIK</td>
                        <td class="{{ $totalSks >= $minimalSks ? 'status-terpenuhi' : 'status-belum' }}">
                            {{ $totalSks >= $minimalSks ? 'TERPENUHI' : 'BELUM TERPENUHI' }}
                        </td>
                        <td>{{ $totalSks }} SKS</td>
                        <td>WEBSITE</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">2</td>
                        <td>MENGIKUTI SELURUH KEGIATAN YANG WAJIB DIIKUTI</td>
                        <td class="{{ $kegiatanWajibSemuaTerpenuhi ? 'status-terpenuhi' : 'status-belum' }}">
                            {{ $kegiatanWajibSemuaTerpenuhi ? 'TERPENUHI' : 'BELUM TERPENUHI' }}
                        </td>
                        <td>{{ $jumlahKegiatanWajibTerpenuhi }}/{{ $totalKegiatanWajib }} kegiatan</td>
                        <td>WEBSITE</td>
                    </tr>
                </tbody>
            </table>

            <!-- Legenda -->
            <div class="legend">
                <span class="legend-item">
                    <span class="legend-color" style="background-color: #006400;"></span> Terpenuhi
                </span>
                <span class="legend-item">
                    <span class="legend-color" style="background-color: #8B0000;"></span> Belum Terpenuhi
                </span>
                <span class="legend-item">
                    <span class="badge-wajib" style="margin-left: 0;">WAJIB</span> Kegiatan Wajib
                </span>
            </div>

            <!-- Detail Kegiatan -->
            @if(count($kegiatanKelompok) > 0)
            @foreach($kegiatanKelompok as $kelompok)
            <div class="kegiatan-section">
                <div class="kegiatan-header">
                    <h4>{{ $kelompok['nama'] }}</h4>
                    @if($kelompok['min_wajib'] > 0)
                    <span class="min-wajib-badge">
                        Minimal {{ $kelompok['min_wajib'] }} kegiatan wajib
                    </span>
                    @endif
                </div>

                <table class="kegiatan-table">
                    @foreach($kelompok['kegiatan'] as $index => $kegiatan)
                    @php
                    $isWajib = $kegiatan['required'];
                    $namaBersih = str_replace('(WAJIB)', '', $kegiatan['nama']);
                    @endphp
                    <tr>
                        <td width="60%">
                            {{ $index + 1 }}. {{ trim($namaBersih) }}
                            @if($isWajib)
                            <span class="badge-wajib">WAJIB</span>
                            @endif
                        </td>
                        <td width="20%" style="text-align: center;">
                            <span class="{{ $kegiatan['status'] == 'TERPENUHI' ? 'badge-terpenuhi' : 'badge-belum' }}">
                                {{ $kegiatan['status'] }}
                            </span>
                        </td>
                        <td width="20%" style="text-align: right;">
                            @if($kegiatan['status'] == 'TERPENUHI')
                            {{ $kegiatan['sks'] }} SKS
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endforeach
            @else
            <div style="text-align: center; padding: 15px; color: #6c757d;">
                <p>Belum ada data kegiatan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="page">
        <div class="content">
            <!-- Header Ringkasan -->
            <div class="header">
                <div class="logo-container">
                    @php
                    $logoPath = public_path('assets/images/profile/logo-pansus.png');
                    @endphp
                    @if(file_exists($logoPath))
                    <img src="{{ asset('assets/images/profile/logo-pansus.png') }}"
                        class="logo-img"
                        alt="Logo PanSus">
                    @else
                    <div class="logo-placeholder">LOGO</div>
                    @endif
                </div>
                <div class="header-text">
                    <h1 class="header-title">PANITIA KHUSUS (PANSUS) FAKULTAS PSIKOLOGI</h1>
                    <h2 class="header-subtitle">UNIVERSITAS ISLAM BANDUNG</h2>
                    <h3 class="header-year">T.A 2025-2026</h3>
                    <h2 class="header-card-title">RINGKASAN KARTU SKS NON AKADEMIK</h2>
                </div>
            </div>

            <!-- Info Mahasiswa -->
            <table class="student-info">
                <tr>
                    <td>NAMA / NPM</td>
                    <td><strong>{{ $student->name }}</strong> ({{ $student->npm }})</td>
                </tr>
                <tr>
                    <td>STATUS KELULUSAN</td>
                    <td>
                        <span class="{{ $isLulus ? 'status-lulus' : 'status-belum-lulus' }}">
                            {{ $isLulus ? 'LULUS' : 'BELUM LULUS' }}
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Ringkasan per Kategori -->
            <h3 class="section-title">RINGKASAN PER KATEGORI KEGIATAN</h3>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Kegiatan</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kegiatanKelompok as $index => $kelompok)
                    @php
                    $total = count($kelompok['kegiatan']);
                    $terpenuhi = collect($kelompok['kegiatan'])->where('status', 'TERPENUHI')->count();
                    $progressPersen = $total > 0 ? round(($terpenuhi / $total) * 100) : 0;
                    $statusKategori = $terpenuhi == $total ? 'TERPENUHI' : 'BELUM TERPENUHI';
                    $statusColor = $terpenuhi == $total ? 'status-terpenuhi' : 'status-belum';
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $kelompok['nama'] }}</td>
                        <td style="text-align: center;">
                            {{ $terpenuhi }}/{{ $total }} kegiatan
                            <small>({{ $progressPersen }}%)</small>
                        </td>
                        <td style="text-align: center; font-weight: bold;" class="{{ $statusColor }}">
                            {{ $statusKategori }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Ringkasan Pencapaian -->
            <div class="ringkasan-section">
                <h4 style="margin: 0 0 8px 0;">RINGKASAN PENCAPAIAN</h4>
                <table class="ringkasan-table">
                    <tr>
                        <td width="60%"><strong>Total SKS yang Diperoleh:</strong></td>
                        <td width="40%"><strong>{{ $totalSks }} SKS</strong></td>
                    </tr>
                    <tr>
                        <td>Minimal SKS yang Diperlukan:</td>
                        <td>{{ $minimalSks }} SKS</td>
                    </tr>
                    <tr>
                        <td>Sisa SKS yang Dibutuhkan:</td>
                        <td class="{{ $totalSks >= $minimalSks ? 'status-terpenuhi' : 'status-belum' }}">
                            {{ max($minimalSks - $totalSks, 0) }} SKS
                        </td>
                    </tr>
                    <tr>
                        <td>Kegiatan Wajib Terpenuhi:</td>
                        <td>{{ $jumlahKegiatanWajibTerpenuhi }}/{{ $totalKegiatanWajib }}</td>
                    </tr>
                    <tr>
                        <td>Kegiatan Wajib Belum Terpenuhi:</td>
                        <td class="status-belum">{{ $totalKegiatanWajib - $jumlahKegiatanWajibTerpenuhi }} kegiatan</td>
                    </tr>
                    <tr>
                        <td><strong>Status Kelulusan:</strong></td>
                        <td>
                            <span class="{{ $isLulus ? 'status-lulus' : 'status-belum-lulus' }}">
                                <strong>{{ $isLulus ? 'LULUS' : 'BELUM LULUS' }}</strong>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Catatan Penting -->
            <div class="notes">
                <strong>📌 CATATAN PENTING:</strong>
                <ul>
                    <li>Status LULUS jika: Total SKS ≥ {{ $minimalSks }} <strong>DAN</strong> semua kegiatan wajib terpenuhi sesuai ketentuan per kategori</li>
                    <li>Kegiatan dengan label <span class="badge-wajib" style="margin-left: 0;">WAJIB</span> harus dipenuhi sesuai minimal per kategori</li>
                    <li>Untuk kategori dengan keterangan "Minimal X kegiatan wajib", cukup memenuhi X kegiatan dari sekian banyak pilihan</li>
                    <li>Dokumen ini dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</li>
                </ul>
            </div>

            <!-- QR Code -->
            <!-- <div class="qr-container">
                <div class="qr-placeholder">
                    QR CODE
                </div>
            </div> -->
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="no-print action-buttons">
        <button onclick="window.print()" class="btn btn-print">
            🖨️ Cetak Kartu SKS
        </button>
        <!-- <a href="{{ route('students.kartu-sks.pdf', $student->id) }}" class="btn btn-pdf" target="_blank">
            📥 Download PDF
        </a> -->
        <div class="timestamp">
            Dokumen ini dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printBtn = document.querySelector('.btn-print');
            if (printBtn) {
                printBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.print();
                });
            }
        });
    </script>
</body>

</html>