@extends('layouts.main')

@section('contents')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Mahasiswa {{ $active }}</h5>
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

    <div style="top:27px; right:27px; position: fixed; z-index: 99999;">
        <div class="alert alert-warning alert-dismissible fade" id="import-alert" role="alert">
            <span id="import-alert-message">warning</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                @csrf
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <div class="custom-file">
                            <label class="custom-file-label" for="photo">Choose file</label>
                            <input type="file" class="custom-file-input" id="photo" name="photo" onchange="fileUpload(this)" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </div>
                        <div class="input-group-append" style="margin-left: 7px;">
                            <button class="btn  btn-primary" id="import-preview-but" type="submit" style="padding: 0px 20px;">Preview</button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="progres-s">
                        <progress value="0" max="100" id="import-progressbar"></progress>
                        <span for="import-progressbar" id="progressbar-percent">Progress - 0%</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" id="import-preview-place">
        
    </div>

    <script>
        $("#student-form").on("submit", function(e) {
            e.preventDefault();

            var data_form = new FormData(this);
            var file = $('input[type=file]')[0].files[0];
            data_form.append('cfu_file', file);

            
            if(file !== undefined && file !== null) {
                $.ajax({
                    url: 'import/read',
                    dataType: 'JSON',
                    type: 'POST',
                    data: data_form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function success(data) {
                        if (data.status == 'success') {
                            var data_counts = data.counts;
                            var prog_val = 0;

                            $("#import-progressbar").prop("max", data_counts);
                            $("#import-progressbar").prop("value", 0);

                            $('#import-preview-place').html(`
                                <div class="card-header">
                                    <h5>&nbsp;</h5>

                                    <div class="card-header-right">
                                        <div class="btn-group" id="import-btn-place">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive" id="import-preview-place">
                                        <table class="table table-hover" id="table-import-preview">

                                        </table>
                                    </div>
                                </div>
                            `);

                            for (var process = 0; process < data_counts; process++) {
                                (function (process) {
                                    setTimeout(function () {
                                        var csrf_token = $("input[name=_token]").val();
                                        $.ajax({
                                            url: 'import/read',
                                            dataType: 'JSON',
                                            type: 'POST',
                                            data: {
                                                _token: csrf_token,
                                                index: process,
                                                req_type: 'preview'
                                            },
                                            success: function success(data_preview) {
                                                if (data_preview.status == 'success') {
                                                    $('#table-import-preview').append(data_preview.content);
                                                } else {
                                                    $("#import-alert-message").html('Ups, '+ data_preview.err_msg);
                                                    $("#import-alert").addClass('show');
                                                }

                                                prog_val++;
                                                $("#import-progressbar").attr("value", prog_val);
                                                var cur_prog_val = parseInt(prog_val) / parseInt(data_counts) * 100;
                                                var prog_percent = parseInt(cur_prog_val);
                                                $("#progressbar-percent").html("Progress - " + prog_percent + "%");
                                                if(prog_percent == 100) {
                                                    $("#import-btn-place").html('<a href="javascript:void(0)" id="import-do-but" class="btn  btn-primary" onclick="doImport('+ data_counts +')">IMPORT</a>');
                                                }
                                                $('#import-preview-but').attr('disabled', 'disabled');
                                            }
                                        });
                                    }, 200 * process);
                                })(process);
                            }
                        } else {
                            $('#import-preview').html("Error" + data.err_msg);
                        }
                    }
                });
            } else {
                $("#import-warning-message").html('Ups, Silakan pilih Filenya terlebih dahulu.');
                $("#import-warning").addClass('show');
            }
            
        });

        window.doImport = function (data_counts) {
            var prog_val = 0;

            $("#import-progressbar").prop("max", data_counts);
            $("#import-progressbar").prop("value", 0);
            $("#import-do-but").remove();

            for (var saving = 0; saving < data_counts; saving++) {
                (function (saving) {
                    setTimeout(function () {
                        var csrf_token = $("input[name=_token]").val();
                        $.ajax({
                            url: 'import/process',
                            dataType: 'JSON',
                            type: 'POST',
                            async: false,
                            data: {
                                _token: csrf_token,
                                index: saving
                            }, 
                            success: function success(data) {
                                $('#tr-import-'+ data.index).removeAttr("class style");
                                if (data.message == 'success') {
                                    $('#td-import-'+ data.index).prepend('<span style="color:#068510;font-weight:bold;">IMPORTED </span></td>');
                                    $('#tr-import-'+ data.index).attr('title', data.data);
                                } else {
                                    $('#td-import-'+ data.index).prepend('<span style="color:#F76565;font-weight:bold;">NOT IMPORTED </td>');
                                    $('#tr-import-'+ data.index).attr('title', data.data);
                                }
                                
                                prog_val++;
                                $("#import-progressbar").attr("value", prog_val);
                                var cur_prog_val = parseInt(prog_val) / parseInt(data_counts) * 100;
                                var prog_percent = parseInt(cur_prog_val);
                                $("#progressbar-percent").html("Progress - " + prog_percent + "%");
                            }
                        });
                    }, 200 * saving);
                })(saving);
            }
        };
    </script>

@endsection