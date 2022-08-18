@extends('layouts.main')

@section('contents')

<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header borderless ">
            <h5>Profile</h5>
            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-more-horizontal"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                        <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body pb-0">
            <form action="{{ route('profile.update', [$student]) }}" method="post" name="student-form" id="student-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control form-control-sm @error('name')  is-invalid @enderror" name="name" id="name" placeholder="Nama" value="{{ $student->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">No Telepon</label>
                    <input type="text" class="form-control form-control-sm @error('phone')  is-invalid @enderror" name="phone" id="phone" placeholder="No Telepon" value="{{ $student->phone }}">
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control form-control-sm @error('email')  is-invalid @enderror" name="email" id="email" placeholder="No Telepon" value="{{ $student->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control form-control-sm @error('address')  is-invalid @enderror" name="address" id="address" rows="3"> {{ $student->address }} </textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" class="form-control form-control-sm @error('date_of_birth')  is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="Tanggal Lahir" value="{{ $student->date_of_birth !== null ? date("Y-m-d", strtotime($student->date_of_birth)) : '' }}">
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

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>
            &nbsp;<br>
            &nbsp;<br>
        </div>
    </div>
</div>

@endsection