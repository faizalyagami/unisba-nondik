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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $student->npm }}</a></li>
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
                <a href="{{ route('student.edit', [$student->id]) }}" class="btn btn-primary"><i class="feather mr-2 icon-edit"></i> Edit</a>
            </div>
        </div>

        <div class="card-body">
            <form action="" method="post" name="student-form" id="student-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{  $student->id }}">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input readonly type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Nama" value="{{ $student->name }}">
                </div>
                <div class="form-group">
                    <label for="phone">No Telepon</label>
                    <input readonly type="text" class="form-control form-control-sm" name="phone" id="phone" placeholder="No Telepon" value="{{ $student->phone }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input readonly type="text" class="form-control form-control-sm" name="email" id="email" placeholder="No Telepon" value="{{ $student->email }}">
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea readonly class="form-control form-control-sm" name="address" id="address" rows="3"> {{$student->address }} </textarea>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input readonly type="date" class="form-control form-control-sm" name="date_of_birth" id="date_of_birth" placeholder="Tanggal Lahir" value="{{ $student->date_of_birth !== null ? date("Y-m-d", strtotime($student->date_of_birth)) : '' }}">
                </div>
                <div class="form-group">
                    <label for="address">Jenis Kelamin</label><br />
                    @foreach ($genders as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $student->gender ? 'checked' : '' }} id="gender-{{ $key }}" name="gender" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="gender-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="address">Agama</label><br />
                    @foreach ($religions as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $student->religion ? 'checked' : '' }} id="religion-{{ $key }}" name="religion" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="religion-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="class_of">Angkatan</label>
                    <select disabled class="form-control @error('class_of')  is-invalid @enderror" name="class_of" id="class_of">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{  $student->class_of == $year ? "selected":"" }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="period">Periode Pengisian</label>
                    <input readonly type="date" class="form-control form-control-sm @error('period')  is-invalid @enderror" name="period" id="period" placeholder="Tanggal Lahir" value="{{ $student->period }}">
                    @error('period')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $student->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="address">Pansus</label><br />
                    @foreach ($pansus as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $student->pansus ? 'checked' : '' }} id="pansus-{{ $key }}" name="pansus" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="pansus-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="">
                    <img class="img-fluid d-block w-10" src="{{ url("uploads/profiles/". $student->photo) }}" alt="{{ $student->name }}">
                </div>
            </form>

        </div>

    </div>

@endsection