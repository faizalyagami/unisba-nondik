@extends('layouts.main')

@section('contents')

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Mahasiswa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>&nbsp;</h5>

        <div class="card-header-right">
            <div class="btn-group card-option">
                <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="feather icon-more-horizontal"></i>
                </button>
                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item"><a href="javascript:void(0)" class="" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="feather mr-2 icon-search"></i> Search & Filter</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Search -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="get">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search & Filter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="search_text" class="col-form-label">Search</label>
                            <input type="text" class="form-control" name="search_text" id="search_text" value="{{  $search_text }}">
                        </div>
                        <div class="form-group">
                            <label for="class_of">Angkatan</label>
                            <select class="form-control @error('class_of')  is-invalid @enderror" name="search_classof" id="class_of">
                                @foreach ($classofs as $year)
                                <option value="{{ $year }}" {{ ($search_classof == $year ? "selected":"") }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="search_status" id="status">
                                @foreach ($status as $key => $val)
                                <option value="{{ $key }}" {{ ($search_status == $key ? "selected":"") }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Periode Pengisian</th>
                        <th>Total SKS</th>
                        <th>Sertifikat</th>
                        <th>Kartu SKS</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($students))
                    @foreach ($students as $key => $student)
                    <tr>
                        <td style="width: 25px;">{{ $students->firstItem() + $key }}</td>
                        <td style="width: 95px;">{{ $student->npm }}</td>
                        <td>
                            @if ($student->photo !== null && $student->photo !== '')
                            <img src="/uploads/{{ $student->photo }}" alt="{{ $student->name }}" class="img-radius wid-40 align-top m-r-15">
                            @endif
                            <div class="d-inline-block">
                                <h6>{{ $student->name }}</h6>
                            </div>
                        </td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $genders[$student->gender] ?? '-' }}</td>
                        <td>{{ $student->class_of }}</td>
                        <td>{{ date("d F Y", strtotime($student->period)) }}</td>
                        <td>
                            @if($student->isLulus)
                            {{ $student->sumsks }} SKS
                            <span class="badge badge-success" title="Kegiatan wajib sudah terpenuhi dan Lulus">
                                <i class="feather icon-check-circle"></i> Lulus
                            </span>
                            @else
                            {{ $student->sumsks }} SKS
                            <span class="badge badge-warning" title="Kegiatan wajib belum terpenuhi">
                                <i class="feather icon-alert-circle"></i>
                            </span>
                            @endif
                        </td>
                        <td id="crtf-td-{{ $student->id }}">
                            @if($student->certificate_approve == 1)
                            <span style="color: #1abc9c;"><i class="feather icon-check" title="Approved"></i></span>
                            @else
                            @if($student->isLulus)
                            <a href="javascript:void(0)" onclick="showmodal({{ $student->id }})" data-toggle="modal" data-target="#exampleModalCenter">
                                <span style="color: #ffc107;"><i class="feather icon-alert-circle" title="Not Approve"></i></span>
                            </a>
                            @else
                            <span style="color: #e74c3c;" title="Tidak dapat approve - syarat kelulusan belum terpenuhi">
                                <i class="feather icon-x-circle"></i>
                            </span>
                            @endif
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('students.kartu-sks', $student->id) }}" class="btn btn-icon btn-info" target="_blank" title="Lihat Kartu SKS {{ $student->name }}">
                                <i class="feather icon-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11" style="text-align: center;">Data Tidak Ditemukan</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            {{ $students->links('vendor.pagination.custom-default') }}
        </div>
    </div>
</div>

<!-- Modal untuk konfirmasi approve -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Approve Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Periksa kembali kesesuaian data.
                    <br>
                    Apakah anda yakin akan menyetujui sertifikat ini?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="btn-ya-approve">Ya, Setujui</button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-icon i {
        font-size: 16px;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .badge {
        padding: 5px 8px;
        font-size: 11px;
        border-radius: 4px;
        font-weight: 500;
        margin-left: 5px;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    /* Hover effect untuk baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(23, 162, 184, 0.05);
    }

    .feather-icon {
        font-size: 18px;
    }
</style>

<script>
    window.onerror = function(msg, url, line) {
        console.log('JavaScript Error: ' + msg + '\nURL: ' + url + '\nLine: ' + line);
        return false;
    };

    window.showmodal = function(id) {
        console.log('showmodal called with id:', id);
        // Simpan ID di data attribute modal
        $('#exampleModalCenter').data('student-id', id);
        // Tampilkan modal
        $('#exampleModalCenter').modal('show');
    }

    $(document).ready(function() {
        console.log('Document ready');

        // Handler untuk tombol Ya di modal
        $("#btn-ya-approve").on("click", function() {
            // Ambil ID dari modal
            var id = $('#exampleModalCenter').data('student-id');
            console.log('btn-ya clicked with id:', id);

            if (!id) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID mahasiswa tidak ditemukan'
                });
                // Tutup modal
                $('#exampleModalCenter').modal('hide');
                return;
            }

            var ajaxurl = "{{ route('student.approve-certificate') }}";
            console.log('ajaxurl:', ajaxurl);

            // Tutup modal terlebih dahulu
            $('#exampleModalCenter').modal('hide');

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                },
                success: function(data) {
                    console.log('success response:', data);
                    Swal.close();

                    if (data.status == 'ok') {
                        // Update icon di tabel
                        $("#crtf-td-" + id).html(`<span style="color: #1abc9c;"><i class="feather icon-check" title="Approved"></i></span>`);

                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Sertifikat berhasil disetujui',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Mahasiswa belum memenuhi syarat kelulusan'
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('error response:', xhr.responseText);
                    Swal.close();

                    try {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Terjadi kesalahan server'
                        });
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan server: ' + errorThrown
                        });
                    }
                }
            });
        });

        // Reset data saat modal ditutup
        $('#exampleModalCenter').on('hidden.bs.modal', function() {
            $(this).removeData('student-id');
        });
    });
</script>

@endsection