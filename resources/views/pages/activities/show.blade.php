@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Activities</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('activity.index') }}">Activities</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $activity->name }}</a></li>
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
                <a href="{{ route('activity.edit', [$activity->id]) }}" class="btn btn-primary"><i class="feather mr-2 icon-edit"></i> Edit</a>
            </div>
        </div>

        <div class="card-body">
            <form action="" method="post" name="activity-form" id="activity-form" class="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $activity->id }}">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input readonly type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Nama" value="{{ $activity->name }}">
                </div>
                <div class="form-group">
                    <label for="address">Status</label><br />
                    @foreach ($status as $key => $value)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input disabled type="radio" {{ $key == $activity->status ? 'checked' : '' }} id="status-{{ $key }}" name="status" value="{{ $key }}" class="custom-control-input">
                            <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Sub Activity</h5>

            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-more-horizontal"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-138px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <li class="dropdown-item"><a href="{{ route('activity.sub.create', [$activity->id]) }}" class=""><i class="feather mr-2 icon-plus"></i> Tambah Sub Baru</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>SKS</th>
                            <th>Status</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($activity->subActivities))
                            @foreach ($activity->subActivities as $key => $subActivity)
                                <tr>
                                    <td>{{ ($key + 1) }}</td>
                                    <td><a href="{{ route('activity.sub.show', [$activity->id, $subActivity->id]) }}"> {{ $subActivity->name }}</a></td>
                                    <td>{{ $subActivity->sks }}</td>
                                    <td>{{ $status[$subActivity->status] }}</td>
                                    <td>{{ $subActivity->notes }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Data Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection