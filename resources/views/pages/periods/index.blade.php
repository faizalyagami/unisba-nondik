@extends('layouts.main')

@section('contents')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Manajemen Periode</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#!">Periode</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Daftar Periode</h5>
        <div class="card-header-right">
            <a href="{{ route('admin.periods.create') }}" class="btn btn-primary btn-sm">
                <i class="feather icon-plus"></i> Tambah Periode
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Periode</th>
                        <th>Tahun Awal</th>
                        <th>Tahun Akhir</th>
                        <th>Semester</th>
                        <th>Nomor Awal</th>
                        <th>Nomor Terakhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $key => $period)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $period->name }}</td>
                        <td>{{ $period->tahun_awal }}</td>
                        <td>{{ $period->tahun_akhir }}</td>
                        <td>{{ ucfirst($period->semester) }}</td>
                        <td>{{ $period->start_order }}</td>
                        <td>{{ $period->current_order }}</td>
                        <td>
                            @if($period->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.periods.edit', $period) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="feather icon-edit"></i>
                                </a>
                                
                                @if(!$period->is_active)
                                <form action="{{ route('admin.periods.activate', $period) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Aktifkan" onclick="return confirm('Aktifkan periode ini? Nomor urut akan dimulai dari {{ $period->start_order }}')">
                                        <i class="feather icon-check"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.periods.reset-order', $period) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" title="Reset Nomor" onclick="return confirm('Reset nomor urut ke {{ $period->start_order }}?')">
                                        <i class="feather icon-rotate-ccw"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus periode ini?')">
                                        <i class="feather icon-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data periode</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection