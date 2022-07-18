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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Import</a></li>
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
                        <li class="dropdown-item"><a href="{{ route('student.export-format') }}" class=""><i class="feather mr-2 icon-log-in" style="transform: rotate(90deg);"></i> Download Format</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form id="student-form" class="" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="input-group">
                        <div class="custom-file">
                            <label class="custom-file-label" for="photo">Choose file</label>
                            <input type="file" class="custom-file-input" id="photo" name="photo" onchange="fileUpload(this)" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </div>
                        <div class="input-group-append">
                            <button class="btn  btn-primary" id="import-preview" type="button">Preview</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="import-progressbar">Progress....</label>
                    <progress value="0" max="100" id="import-progressbar" style="width:100%; height: 25px;"></progress>
                </div>
            </form>
        </div>
    </div>

@endsection