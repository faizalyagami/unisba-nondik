@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Users</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $user->name }}</a></li>
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
                <a href="{{ route('user.edit', [$user->id]) }}" class="btn btn-primary"><i class="feather mr-2 icon-edit"></i> Edit</a>
            </div>
        </div>

        <div class="card-body">
            <form action="" method="post" name="user-form" id="user-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input readonly type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Nama" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="name">Username</label>
                    <input readonly type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Nama" value="{{ $user->username }}">
                </div>
                <div class="form-group">
                    <label for="name">Email</label>
                    <input readonly type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Nama" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="address">Level</label><br />
                    @foreach ($levels as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $user->level ? 'checked' : '' }} id="status-{{ $key }}" name="level" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $user->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

@endsection