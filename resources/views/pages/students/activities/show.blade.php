@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Aktivitas Mahasiswa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.activity.index') }}">Aktivitas Mahasiswa</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $studentActivity->student->name ." - ". $studentActivity->subActivity->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div style="top:27px; right:27px; position: fixed; z-index: 99999;">
        @if (session('success'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        @endif
    </div>

    <div class="card">

        <div class="card-body">
            <form action="" method="post" name="student-activity-form" id="student-activity-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="student">Mahasiswa</label>
                    <input readonly type="text" class="form-control form-control-sm" name="student" id="student" placeholder="Mahasiswa" value="{{ $studentActivity->student->name }}">
                </div>
                <div class="form-group">
                    <label for="sub-activity">Aktivitas</label>
                    <input readonly type="text" class="form-control form-control-sm" name="subActivity" id="sub-activity" placeholder="Sub Activity..." value="{{ $studentActivity->subActivity->name }}">
                </div>
                <div class="form-group">
                    <label for="notes">Keterangan</label>
                    <textarea readonly class="form-control" name="notes" id="notes" rows="3">{{ $studentActivity->notes }}</textarea>
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <br>
                    @if($studentActivity->attachment !== null && $studentActivity->attachment != '')
                        <a href="javascript:void(0)" download><span class="btn btn-sm btn-info">{{ $studentActivity->attachment }} </span></a>
                    @endif
                </div>

                <a href="{{ route('student.activity.edit', [$studentActivity->id]) }}" class="btn  btn-primary">Edit</a>
            </form>

        </div>

    </div>

    <div class="card">

        <div class="card-body">
            <form action="{{ route('student.activity.approve', [$studentActivity->id]) }}" method="post" name="approve-form" id="approve-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $studentActivity->id }}">
                <div class="form-group">
                    <label for="notes">Alasan / Keterangan</label>
                    <textarea class="form-control @error('notes')  is-invalid @enderror" name="notes" id="notes" rows="3"></textarea>
                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn  btn-primary" name="action" value="Approv">Approve</button>
                <button type="submit" class="btn  btn-primary" name="action" value="Reject">Reject</button>
            </form>

        </div>

    </div>

    <div class="card">
        <div class="card-header">
            <h5>Log Activity</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Aktivitas</th>
                            <th>Tanggal</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentActivity->studentActivityLogs))
                            @php($key = 0)
                            @foreach ($studentActivity->studentActivityLogs as $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value->subActivity->name }}</td>
                                    <td>{{ date("d F Y", strtotime($value->created_at)) }}</td>
                                    <td>{{$value->notes }}</td>
                                    <td>{{ $status[$value->status] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Data Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection