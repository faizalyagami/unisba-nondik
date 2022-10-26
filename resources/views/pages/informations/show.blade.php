@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Informations</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('information.index') }}">Informations</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $information->name }}</a></li>
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
        <div class="card-header">
            <div style="text-align: right;">
                <a href="{{ route('information.edit', [$information->id]) }}" class="btn btn-primary"><i class="feather mr-2 icon-edit"></i> Edit</a>
            </div>
        </div>

        <div class="card-body">
            <form action="" method="post" name="information-form" id="information-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $information->id }}">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input readonly type="text" class="form-control form-control-sm" name="title" id="title" placeholder="Judul" value="{{ $information->title }}">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea readonly class="form-control form-control-sm @error('description')  is-invalid @enderror" name="description" id="description" rows="3"> {{ $information->description }} </textarea>
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $information->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

@endsection