@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Activitas Mahasiswa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                    </ul>
                </div>
            </div>
        </div>
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
                        @if(auth()->user()->level != 2)
                            <li class="dropdown-item"><hr></li>
                            <li class="dropdown-item"><a href="{{ route('student.activity.create') }}" class=""><i class="feather mr-2 icon-plus"></i> Tambah Baru</a></li>
                        @endif
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
                            @if(auth()->user()->level != 3)
                                <th>Mahasiswa</th>
                            @endif
                            <th>Nama Aktivitas</th>
                            <th>Tanggal Buat</th>
                            <th>Attachment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($studentActivities))
                            @foreach ($studentActivities as $key => $studentActivity)
                                <tr>
                                    <td>{{ $studentActivities->firstItem() + $key }}</td>
                                    @if(auth()->user()->level != 3)
                                        <td>{{ $studentActivity->student->name }}</td>
                                    @endif
                                    <td>{{ $studentActivity->subActivity->name }}</td>
                                    <td>{{ date("d F Y", strtotime($studentActivity->created_at)) }}</td>
                                    <td>
                                        @if($studentActivity->attachment !== null && $studentActivity->attachment != '')
                                            <a href="/uploads/attachments/{{ $studentActivity->attachment }}" download><span class="btn btn-sm btn-info">{{ $studentActivity->attachment }} </span></a>
                                        @endif
                                    </td>
                                    <td>{{ $status[$studentActivity->status] }}</td>
                                    <td>
                                        <a href="{{ route('student.activity.show', [$studentActivity->id]) }}" class="btn btn-sm btn-primary" title="Show"><i class="feather icon-search"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Data Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $studentActivities->links('vendor.pagination.custom-default') }}
            </div>
        </div>
    </div>

@endsection