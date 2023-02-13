@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Activities</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('activity.index') }}">Activities</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $activity->name }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Sub Baru</a></li>
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
            <form action="{{ route('activity.sub.store', [$activity->id]) }}" method="post" name="sub-activity-form" id="sub-activity-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control form-control-sm @error('name')  is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ old("name") }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sks">Jumlah SKS</label>
                    <input type="text" class="form-control form-control-sm @error('sks')  is-invalid @enderror" name="sks" id="sks" placeholder="Jumlah SKS" value="{{ old("sks") }}">
                    @error('sks')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control form-control-sm @error('notes')  is-invalid @enderror" name="notes" id="notes" rows="3"> {{ old("notes") }} </textarea>
                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="required">Wajib</label><br />
                    @foreach ($needs as $key => $need)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $key == 0 ? 'checked' : '' }} id="required-{{ $key }}" name="required" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="required-{{ $key }}">{{ $need }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection