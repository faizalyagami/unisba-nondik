@extends('layouts.main')

@section('contents')


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

<div class="col-lg-12 col-md-12">
    <div class="card table-card review-card">
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
            <div class="review-block">
                <div class="row">
                    <div class="col-sm-auto p-r-0">
                        @if(auth()->user()->load('student')->student)
                            <img src="{{ url("uploads/profiles/". auth()->user()->load('student')->student->photo) }}" alt="{{ auth()->user()->load('student')->name }}" class="img-radius profile-img cust-img">
                        @else
                            <img src="{{ url("assets/images/user/avatar-4.jpg") }}" alt="user image" class="img-radius profile-img cust-img">
                        @endif
                    </div>
                    <div class="col">
                        @if ($student->student !== null)
                            <h6 class="m-b-15">{{ $student->student->name }} [ {{ $student->student->npm }} ]</h6>
                            <p class="m-t-15 m-b-15 text-muted">{{ $student->student->address }}</p>
                            <a href="javascript:void(0)" class="m-r-30 text-muted" title="Phone"><i class="feather icon-phone m-r-15"></i>{{ $student->student->phone }}</a>
                            <a href="javascript:void(0)" class="m-r-30 text-muted" title="Gender"><i class="feather icon-user m-r-15"></i>{{ $genders[$student->student->gender] }}</a>
                            <a href="javascript:void(0)" class="m-r-30 text-muted" title="Religion"><i class="feather icon-heart m-r-15"></i>{{ $religions[$student->student->religion] }}</a>
                            <a href="javascript:void(0)" class="m-r-30 text-muted" title="Date Of Birth"><i class="feather icon-clock m-r-15"></i>{{ date("d F Y", strtotime($student->student->date_of_birth)) }}</a>
                            <a href="{{ route('profile.edit') }}" title="Edit Profile"><i class="feather icon-edit text-muted"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ route('profile.edit-password') }}" title="Change Password"><i class="feather icon-refresh-cw text-muted"></i></a>
                        @else
                            <h6 class="m-b-15">{{ $student->name }}</h6>
                            <p class="m-t-15 m-b-15 text-muted">{{ $student->username }}</p>
                            <a href="javascript:void(0)" class="m-r-30 text-muted" title="Email"><i class="feather icon-mail m-r-15"></i>{{ $student->email }}</a>
                            <a href="{{ route('profile.edit') }}" title="Edit Profile"><i class="feather icon-edit text-muted"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ route('profile.edit-password') }}" title="Change Password"><i class="feather icon-refresh-cw text-muted"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection