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
                    <label for="organizer">Penyelenggara</label>
                    <input type="text" class="form-control" @error('organizer') required @enderror name="organizer" id="organizer" rows="3" value="{{ $studentActivity->organizer }}">
                    @error('organizer')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="place">Tempat</label>
                    <input type="text" class="form-control" @error('place') required @enderror name="place" id="place" rows="3" value="{{ $studentActivity->place }}">
                    @error('place')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="held_date">Tanggal</label>
                    <input type="date" class="form-control" @error('held_date') required @enderror name="held_date" id="held_date" rows="3" value="{{ $studentActivity->held_date }}">
                    @error('held_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="participation">Peran</label>
                    <input type="text" class="form-control" @error('participation') required @enderror name="participation" id="participation" rows="3" value="{{ $studentActivity->participation }}">
                    @error('participation')
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
                    <label for="attachment">Attachment ( G-Drive link )</label>
                    <input type="text" class="form-control" @error('attachment') required @enderror name="attachment" id="attachment" rows="3" value="{{ $studentActivity->attachment }}">
                    @error('attachment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
            </form>

        </div>

    </div>

@endsection