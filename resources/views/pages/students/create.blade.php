@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Mahasiswa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Mahasiswa</a></li>
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
            <form action="{{ route('student.store') }}" method="post" name="student-form" id="student-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="npm">NPM</label>
                    <input type="text" class="form-control form-control-sm @error('npm')  is-invalid @enderror" name="npm" id="npm" placeholder="NPM" value="{{ old("npm") }}">
                    @error('npm')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
                    <label for="phone">No Telepon</label>
                    <input type="text" class="form-control form-control-sm @error('phone')  is-invalid @enderror" name="phone" id="phone" placeholder="No Telepon" value="{{ old("phone") }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-sm @error('email')  is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old("email") }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control form-control-sm @error('address')  is-invalid @enderror" name="address" id="address" rows="3"> {{ old("address") }} </textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" class="form-control form-control-sm @error('date_of_birth')  is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="Tanggal Lahir" value="{{ old("date_of_birth") }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Jenis Kelamin</label><br />
                    @foreach ($genders as $gender)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $gender->value == 1 ? 'checked' : '' }} id="gender-{{ $gender->value }}" name="gender" value="{{ $gender->value }}" class="custom-control-input">
                            <label class="custom-control-label" for="gender-{{ $gender->value }}">{{ $gender->show }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="address">Agama</label><br />
                    @foreach ($religions as $religion)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $religion->value == 1 ? 'checked' : '' }} id="religion-{{ $religion->value }}" name="religion" value="{{ $religion->value }}" class="custom-control-input">
                            <label class="custom-control-label" for="religion-{{ $religion->value }}">{{ $religion->show }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="photo">Choose file</label>
                        <input type="file" class="custom-file-input" id="photo" name="photo" onchange="fileUpload(this)">
                    </div>
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection