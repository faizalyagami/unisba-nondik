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
                        <li class="breadcrumb-item"><a href="{{ route('activity.sub.show', [$activity->id, $subActivity->id]) }}">{{ $subActivity->name }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <form action="{{ route('activity.sub.update', [$activity->id, $subActivity->id]) }}" method="post" name="sub-activity-form" id="sub-activity-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control form-control-sm @error('name')  is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ $subActivity->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sks">Jumlah SKS</label>
                    <input type="text" class="form-control form-control-sm @error('sks')  is-invalid @enderror" name="sks" id="sks" placeholder="Jumlah SKS" value="{{ $subActivity->sks }}">
                    @error('sks')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="required">Wajib</label><br />
                    @foreach ($needs as $key => $need)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $key == $subActivity->required ? 'checked' : '' }} id="required-{{ $key }}" name="required" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="required-{{ $key }}">{{ $need }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control form-control-sm @error('notes')  is-invalid @enderror" name="notes" id="notes" rows="3"> {{ $subActivity->notes }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $key == $subActivity->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection