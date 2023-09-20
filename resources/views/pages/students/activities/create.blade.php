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
                        <li class="breadcrumb-item"><a href="{{ $user->level == 3 ? route('student.activity.details') : route('student.activity.index') }}">Aktivitas Mahasiswa</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Baru</a></li>
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
            <form action="{{ route('student.activity.store') }}" method="post" name="student-activity-form" id="student-activity-form" class="needs-validation @if($errors->any()) was-validated @endif" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="sub-activity">Aktivitas</label>
                        <select class="form-control" @error('subActivity') required @enderror name="subActivity" id="sub-activity">
                            <option value="">--- Aktivitas ---</option>
                            @foreach ($activities as $item)
                                <optgroup label="{{ $item->name }}">
                                    @foreach ($item->subActivities as $subitem)
                                        <option value="{{ $subitem->id }}" {{ (old("subActivity") == $subitem->id ? "selected":"") }}>{{ $subitem->name .' ['. $subitem->sks .' SKS]' }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('subActivity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="organizer">Penyelenggara</label>
                        <input type="text" class="form-control" @error('organizer') required @enderror name="organizer" id="organizer" rows="3" value="{{ old("organizer") }}">
                        @error('organizer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="place">Tempat</label>
                        <input type="text" class="form-control" @error('place') required @enderror name="place" id="place" rows="3" value="{{ old("place") }}">
                        @error('place')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="held_date">Tanggal</label>
                        <input type="date" class="form-control" @error('held_date') required @enderror name="held_date" id="held_date" rows="3" value="{{ old("held_date") }}">
                        @error('held_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="participation">Peran</label>
                        <input type="text" class="form-control" @error('participation') required @enderror name="participation" id="participation" rows="3" value="{{ old("participation") }}">
                        @error('participation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="notes">Keterangan</label>
                        <textarea class="form-control" @error('notes') required @enderror name="notes" id="notes" rows="3">{{ old("notes") }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="attachment">Attachment ( G-Drive link )</label>
                        <input type="text" class="form-control" @error('attachment') required @enderror name="attachment" id="attachment" rows="3" value="{{ old("attachment") }}">
                        @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection