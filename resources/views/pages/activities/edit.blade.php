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
                        <li class="breadcrumb-item"><a href="{{ route('activity.show', [$activity->id]) }}">{{ $activity->name }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <form action="{{ route('activity.update', [$activity]) }}" method="post" name="activity-form" id="activity-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control form-control-sm @error('name')  is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ $activity->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $key == $activity->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection