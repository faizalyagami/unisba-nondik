@extends('layouts.main')

@section('contents')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Periode</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.periods.index') }}">Periode</a></li>
                    <li class="breadcrumb-item"><a href="#!">Edit</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Form Edit Periode</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.periods.update', $period) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Awal</label>
                <div class="col-sm-10">
                    <input type="number" name="tahun_awal" class="form-control @error('tahun_awal') is-invalid @enderror" value="{{ old('tahun_awal', $period->tahun_awal) }}" min="2000" max="2100" required>
                    @error('tahun_awal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tahun Akhir</label>
                <div class="col-sm-10">
                    <input type="number" name="tahun_akhir" class="form-control @error('tahun_akhir') is-invalid @enderror" value="{{ old('tahun_akhir', $period->tahun_akhir) }}" min="2000" max="2100" required>
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
                        <option value="ganjil" {{ old('semester', $period->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('semester', $period->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
                        <option value="antara" {{ old('semester', $period->semester) == 'antara' ? 'selected' : '' }}>Antara</option>
                    </select>
                    @error('semester')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nomor Awal</label>
                <div class="col-sm-10">
                    <input type="number" name="start_order" class="form-control @error('start_order') is-invalid @enderror" value="{{ old('start_order', $period->start_order) }}" min="1" required>
                    <small class="form-text text-muted">Nomor sertifikat akan dimulai dari angka ini</small>
                    @error('start_order')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status Aktif</label>
                <div class="col-sm-10">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $period->is_active) ? 'checked' : '' }}>
                            <span class="cr"><i class="cr-icon feather icon-check"></i></span>
                            <span>Aktifkan periode ini</span>
                        </label>
                    </div>
                    <small class="form-text text-muted">Hanya satu periode yang dapat aktif dalam satu waktu</small>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.periods.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection