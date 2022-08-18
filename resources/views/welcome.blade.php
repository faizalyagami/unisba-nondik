@extends('layouts.main')

@section('contents')

    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard Activities</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard Activities</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">

        <!-- table card-1 start -->
        <div class="col-md-12 col-xl-4">
            <!-- widget primary card start -->
            <div class="card flat-card widget-primary-card">
                <div class="row-table">
                    <div class="col-sm-3 card-body">
                        <i class="feather icon-star-on"></i>
                    </div>
                    <div class="col-sm-9">
                        <h4>
                            @if ($needed !== null)
                                {{ $needed->value }} +
                            @else
                                0 +
                            @endif
                        </h4>
                        <h6>SKS Needed</h6>
                    </div>
                </div>
            </div>
            <!-- widget primary card end -->
        </div>
        <!-- table card-1 end -->

        <!-- table card-2 start -->
        <div class="col-md-12 col-xl-4">
            <!-- widget-success-card start -->
            <div class="card flat-card widget-purple-card">
                <div class="row-table">
                    <div class="col-sm-3 card-body" @if($result === "Belum Cukup") style="background-color: crimson" @endif>
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="col-sm-9">
                        <h4>
                            @if ($achievement !== null && $achievement->sks !== null)
                                {{ $achievement->sks .' ('. $result .')' }}
                            @else
                                0 (Belum Cukup)
                            @endif
                        </h4>
                        <h6>Achievements</h6>
                    </div>
                </div>
            </div>
            <!-- widget-success-card end -->
        </div>
        <!-- table card-2 end -->
        @if($result !== "Belum Cukup")
            <!-- table card-3 start -->
            <div class="col-md-12 col-xl-4">
                <!-- widget-success-card start -->
                <div class="card flat-card widget-purple-card">
                    <div class="row-table">
                        <div class="col-sm-3 card-body" style="background-color: rgb(13, 145, 222)">
                            <a href="{{ route('profile.print-certificate') }}"><i class="fas fa-print"></i></a>
                        </div>
                        <div class="col-sm-9">
                            <h4>
                                Print
                            </h4>
                            <h6>Certificate</h6>
                        </div>
                    </div>
                </div>
                <!-- widget-success-card end -->
            </div>
            <!-- table card-3 end -->
        @endif

        <!-- prject ,team member start -->
        <div class="col-xl-12 col-md-12">

            <div class="card table-card">
                <div class="card-header">
                    <h5>Projects</h5>
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
                <div class="card-body p-0">
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
                                    @php($key = 0)
                                    @foreach ($studentActivities as $studentActivity)
                                        <tr>
                                            <td>{{ ++$key }}</td>
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
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection