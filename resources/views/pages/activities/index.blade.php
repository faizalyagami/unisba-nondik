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
                        <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
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
            <h5>&nbsp;</h5>

            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="feather icon-more-horizontal"></i>
                    </button>
                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-138px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <li class="dropdown-item"><a href="javascript:void(0)" class="" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="feather mr-2 icon-search"></i> Search</a></li>
                        <li class="dropdown-item"><hr></li>
                        <li class="dropdown-item"><a href="{{ route('activity.create') }}" class=""><i class="feather mr-2 icon-plus"></i> Tambah Baru</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="get">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Search & Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="search_text" class="col-form-label">Search</label>
                                <input type="text" class="form-control" name="search_text" id="search_text" value="{{  $search_text }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Status</label><br />
                                @foreach ($status as $key => $value)
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" {{ $key == $search_status ? 'checked' : '' }} id="status-{{ $key }}" name="search_status" value="{{ $key }}" class="custom-control-input">
                                        <label class="custom-control-label" for="status-{{ $key }}">{{ $value }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn  btn-primary" value="Search">
                        </div>
                    </form>
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($activities))
                            @foreach ($activities as $key => $activity)
                                <tr>
                                    <td>{{ $activities->firstItem() + $key }}</td>
                                    <td><a href="{{ route('activity.show', $activity->id) }}"> {{ $activity->name }}</a></td>
                                    <td>{{ $status[$activity->status] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Data Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $activities->links('vendor.pagination.custom-default') }}
            </div>
        </div>
    </div>

@endsection