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
            <form action="{{ route('profile.update-password') }}" method="post" name="student-form" id="student-form" class="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control form-control-sm @error('password')  is-invalid @enderror" name="password" id="password" value="">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control form-control-sm @error('password_confirmation')  is-invalid @enderror" name="password_confirmation" id="confirm-password" value="">
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn  btn-primary">Simpan</button>
            </form>
            &nbsp;<br>
            &nbsp;<br>
        </div>
    </div>
</div>

@endsection