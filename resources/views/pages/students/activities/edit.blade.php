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
                        <li class="breadcrumb-item"><a href="{{ route('student.activity.show', [$studentActivity->id]) }}">{{ $studentActivity->student->name ." - ". $studentActivity->subActivity->name }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
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
            <form action="{{ route('student.activity.update', [$studentActivity->id]) }}" method="post" name="student-activity-form" id="student-activity-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="sub-activity">Aktivitas</label>
                    <select class="form-control @error('subActivity')  is-invalid @enderror" name="subActivity" id="sub-activity">
                        <option value="">--- Ativitas ---</option>
                        @foreach ($activities as $item)
                            <optgroup label="{{ $item->name }}">
                                @foreach ($item->subActivities as $subitem)
                                    <option value="{{ $subitem->id }}" {{ $studentActivity->sub_activity_id == $subitem->id ? "selected" : "" }}>{{ $subitem->name .' ['. $subitem->sks .' SKS]' }}</option>
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
                <div class="form-group">
                    <label for="notes">Keterangan</label>
                    <textarea class="form-control @error('notes')  is-invalid @enderror" name="notes" id="notes" rows="3">{{ $studentActivity->notes }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <br>
                    @if($studentActivity->attachment !== null && $studentActivity->attachment != '')
                        <a href="javascript:void(0)" download><span class="btn btn-sm btn-info">{{ $studentActivity->attachment }} </span></a>
                    @endif
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="attachment">Choose file</label>
                        <input type="file" class="custom-file-input" id="photo" name="attachment" onchange="fileUpload(this)">
                        @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>

        </div>

    </div>

@endsection