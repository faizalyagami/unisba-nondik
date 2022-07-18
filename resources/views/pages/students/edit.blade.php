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
                        <li class="breadcrumb-item"><a href="{{ route('student.show', [$student->id]) }}">{{ $student->npm }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-body">
            <form action="{{ route('student.update', [$student]) }}" method="post" name="student-form" id="student-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="npm">NPM</label>
                    <input type="text" class="form-control @error('npm')  is-invalid @enderror" name="npm" id="npm" placeholder="NPM" value="{{ $student->npm }}">
                    @error('npm')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name')  is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ $student->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">No Telepon</label>
                    <input type="text" class="form-control @error('phone')  is-invalid @enderror" name="phone" id="phone" placeholder="No Telepon" value="{{ $student->phone }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control @error('address')  is-invalid @enderror" name="address" id="address" rows="3"> {{ $student->address }} </textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('date_of_birth')  is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="Tanggal Lahir" value="{{ $student->date_of_birth !== null ? date("Y-m-d", strtotime($student->date_of_birth)) : '' }}">
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
                            <input type="radio" {{ $gender->value == $student->gender ? 'checked' : '' }} id="gender-{{ $gender->value }}" name="gender" value="{{ $gender->value }}" class="custom-control-input">
                            <label class="custom-control-label" for="gender-{{ $gender->value }}">{{ $gender->show }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="address">Agama</label><br />
                    @foreach ($religions as $religion)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $religion->value == $student->religion ? 'checked' : '' }} id="religion-{{ $religion->value }}" name="religion" value="{{ $religion->value }}" class="custom-control-input">
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
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" {{ $key == $student->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value}}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>

        </div>

    </div>

@endsection