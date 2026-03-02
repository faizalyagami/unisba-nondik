@extends('layouts.main')

@section('contents')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah Periode Baru</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.periods.index') }}">Periode</a></li>
                    <li class="breadcrumb-item"><a href="#!">Tambah</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Form Tambah Periode</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.periods.store') }}" method="POST">
            @csrf
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Awal</label>
                <div class="col-sm-10">
                    <input type="number" name="tahun_awal" class="form-control @error('tahun_awal') is-invalid @enderror" value="{{ old('tahun_awal') }}" min="2000" max="2100" required>
                    @error('tahun_awal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Akhir</label>
                <div class="col-sm-10">
                    <input type="number" name="tahun_akhir" class="form-control @error('tahun_akhir') is-invalid @enderror" value="{{ old('tahun_akhir') }}" min="2000" max="2100" required>
                    <small class="form-text text-muted">Harus lebih besar dari tahun awal</small>
                    @error('tahun_akhir')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-10">
                    <select name="semester" class="form-control @error('semester') is-invalid @enderror" required>
                        <option value="">Pilih Semester</option>
                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        <option value="antara" {{ old('semester') == 'antara' ? 'selected' : '' }}>Antara</option>
                    </select>
                    @error('semester')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nomor Awal</label>
                <div class="col-sm-10">
                    <input type="number" name="start_order" class="form-control @error('start_order') is-invalid @enderror" value="{{ old('start_order', 1) }}" min="1" required>
                    <small class="form-text text-muted">Nomor sertifikat akan dimulai dari angka ini</small>
                    @error('start_order')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection