@extends('layouts.main')

@section('contents')

<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard Activities</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard Activities</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">

    <!-- Card SKS Needed -->
    <div class="col-md-12 col-xl-4">
        <div class="card flat-card widget-primary-card">
            <div class="row-table">
                <div class="col-sm-3 card-body">
                    <i class="feather icon-star-on"></i>
                </div>
                <div class="col-sm-9">
                    <h4>
                        @if ($needed !== null)
                        {{ $needed->value }} +
                        @else
                        0 +
                        @endif
                    </h4>
                    <h6>SKS Dibutuhkan</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pencapaian SKS -->
    <div class="col-md-12 col-xl-4">
        <div class="card flat-card widget-purple-card">
            <div class="row-table">
                <div class="col-sm-3 card-body" @if($result==="Belum Cukup" ) style="background-color: crimson" @endif>
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="col-sm-9">
                    <h4>
                        @if ($achievement !== null && $achievement->sks !== null)
                        {{ $achievement->sks .' ('. $result .')' }}
                        @else
                        0 (Belum Cukup)
                        @endif
                    </h4>
                    <h6>Pencapaian SKS</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Cetak Sertifikat (hanya jika LULUS dan sudah di-approve wadek) -->
    @if($isLulusAndApproved)
    <div class="col-md-12 col-xl-4">
        <div class="card flat-card widget-purple-card">
            <div class="row-table">
                <div class="col-sm-3 card-body" style="background-color: rgb(13, 145, 222)">
                    <a href="{{ route('profile.print-certificate') }}" target="_blank">
                        <i class="fas fa-print"></i>
                    </a>
                </div>
                <div class="col-sm-9">
                    <h4>Cetak</h4>
                    <h6>Sertifikat</h6>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informasi -->
    <div class="col-xl-12 col-md-12">

        @if($information !== null)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">{{ $information->title }}</h4>
            <p>{!! $information->description !!}</p>
            <p class="mb-0">&nbsp;</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        @endif

        <!-- Notifikasi untuk Wadek/Pansus jika ada perbedaan perhitungan SKS -->
        @if(in_array(auth()->user()->level, [2, 4]) && isset($dataKartu))
        @php
        $sksApprove = \App\Models\StudentActivity::join('sub_activities', 'sub_activities.id', 'student_activities.sub_activity_id')
        ->where('student_id', auth()->user()->student_id)
        ->where('student_activities.status', 3)
        ->sum('sub_activities.sks');
        @endphp

        @if($sksApprove != $dataKartu['totalSks'])
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h4 class="alert-heading"><i class="feather icon-info"></i> Informasi Perhitungan SKS</h4>
            <p>
                Total SKS dari kegiatan yang di-approve: <strong>{{ $sksApprove }} SKS</strong><br>
                SKS yang dihitung untuk kelulusan: <strong>{{ $dataKartu['totalSks'] }} SKS</strong><br>
                Selisih: <strong>{{ $sksApprove - $dataKartu['totalSks'] }} SKS</strong>
            </p>
            <p class="mb-0">
                <small class="text-muted">
                    <i class="feather icon-alert-circle"></i>
                    Beberapa kegiatan mungkin tidak dihitung karena aturan khusus
                    (misal: maksimal SKS per kategori, atau hanya X kegiatan wajib dari sekian pilihan).
                    Harap periksa kembali kegiatan yang di-approve.
                </small>
            </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        @endif

        <!-- Daftar Aktivitas -->
        <div class="card table-card">
            <div class="card-header">
                <h5>Daftar Kegiatan Mahasiswa</h5>
                @if(in_array(auth()->user()->level, [2, 3]))
                @if($requiredHas < $required->value)
                    <span class="blink_me" style="color: #fb786e">Anda belum mengikuti {{ $required->value - $requiredHas }} kegiatan wajib.</span>
                    @endif
                    @endif
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                            </ul>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <!-- Form Show Entries -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="dataTables_length">
                        <form method="GET" action="{{ url()->current() }}" id="perPageForm">
                            <label>
                                Tampilkan
                                <select name="per_page" class="form-control form-control-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                entri
                            </label>
                            @foreach(request()->except('per_page') as $key => $value)
                            @if(is_array($value))
                            @foreach($value as $k => $v)
                            <input type="hidden" name="{{ $key }}[{{ $k }}]" value="{{ $v }}">
                            @endforeach
                            @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                            @endforeach
                        </form>
                    </div>
                    <div class="dataTables_info">
                        Menampilkan {{ $studentActivities->firstItem() }} sampai {{ $studentActivities->lastItem() }} dari {{ $studentActivities->total() }} entri
                    </div>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                @if(auth()->user()->level != 3)
                                <th>Mahasiswa</th>
                                @endif
                                <th>Nama Kegiatan</th>
                                <th>Penyelenggara</th>
                                <th>Tempat</th>
                                <th>Tanggal</th>
                                <th>Peran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($studentActivities as $studentActivity)
                            <tr>
                                <td>{{ $studentActivities->firstItem() + $loop->index }}</td>
                                @if(auth()->user()->level != 3)
                                <td><strong>{{ $studentActivity->student->name }}</strong></td>
                                @endif
                                <td>
                                    {{ $studentActivity->subActivity->name }}
                                    @if(str_contains($studentActivity->subActivity->name, '(WAJIB)'))
                                    <span class="badge badge-warning">WAJIB</span>
                                    @endif
                                </td>
                                <td>{{ $studentActivity->organizer }}</td>
                                <td>{{ $studentActivity->place }}</td>
                                <td>{{ $studentActivity->held_date ? date("d F Y", strtotime($studentActivity->held_date)) : '-' }}</td>
                                <td>{{ $studentActivity->participation }}</td>
                                <td>
                                    @php
                                    $statusClass = [
                                    1 => 'badge-secondary',
                                    2 => 'badge-info',
                                    3 => 'badge-success',
                                    4 => 'badge-danger',
                                    ];
                                    $statusText = [
                                    1 => 'Open',
                                    2 => 'Review',
                                    3 => 'Approve',
                                    4 => 'Reject',
                                    ];
                                    @endphp
                                    <span class="badge {{ $statusClass[$studentActivity->status] ?? 'badge-secondary' }}">
                                        {{ $statusText[$studentActivity->status] ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('student.activity.show', [$studentActivity->id]) }}" class="btn btn-sm btn-primary" title="Detail">
                                            <i class="feather icon-search"></i>
                                        </a>
                                        @if($studentActivity->attachment)
                                        <a href="/uploads/attachments/{{ $studentActivity->attachment }}" download class="btn btn-sm btn-info" title="Download">
                                            <i class="feather icon-download"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data kegiatan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($studentActivities->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($studentActivities->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="feather icon-chevron-left"></i></span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $studentActivities->previousPageUrl() }}" rel="prev">
                                    <i class="feather icon-chevron-left"></i>
                                </a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($studentActivities->getUrlRange(1, $studentActivities->lastPage()) as $page => $url)
                            @if ($page == $studentActivities->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($studentActivities->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $studentActivities->nextPageUrl() }}" rel="next">
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="feather icon-chevron-right"></i></span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .blink_me {
        animation: blinker 1.5s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0.5;
        }
    }

    .badge {
        padding: 5px 8px;
        font-size: 11px;
        border-radius: 4px;
        font-weight: 500;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    /* Pagination styling */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
        margin: 0;
    }

    .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        text-decoration: none;
        transition: all 0.2s;
    }

    .page-link:hover {
        z-index: 2;
        color: #0056b3;
        text-decoration: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-link:focus {
        z-index: 3;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Hover effect untuk baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    /* Styling untuk tombol aksi */
    .btn-group .btn {
        margin: 0 2px;
    }
</style>

@endsection