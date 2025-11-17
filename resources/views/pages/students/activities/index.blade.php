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
                        <li class="dropdown-item"><a href="javascript:void(0)" class="" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="feather mr-2 icon-search"></i> Search & Filter</a></li>
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
                                <label for="people">Student</label>
                                <select class="form-control @error('people')  is-invalid @enderror" name="search_people" id="people">
                                    @foreach ($peoples as $key => $val)
                                        <option value="{{ $key }}" {{ ($search_people == $key ? "selected":"") }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="activities">Activities</label><br />
                                @foreach($statusActivity as $key => $value)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" {{ $key == $search_statusActivity ? 'checked': '' }}id="statusActivity-{{ $key }}" name="search_statusActivity" value="{{ $key }}" class="custom-control-input">
                                    <label class="custom-control-label" for="statusActivity-{{ $key }}">{{ $value }}</label>
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="class_of">Angkatan</label>
                                <select class="form-control @error('class_of')  is-invalid @enderror" name="search_classof" id="class_of">
                                    @foreach ($classofs as $year)
                                        <option value="{{ $year }}" {{ ($search_classof == $year ? "selected":"") }}>{{ $year }}</option>
                                    @endforeach
                                </select>
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
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Periode Pengisian</th>
                            <th>Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($students))
                            @foreach ($students as $key => $student)
                                <tr>
                                    <td style="width: 25px;">{{ $students->firstItem() + $key }}</td>
                                    <td style="width: 95px;">{{ $student->npm }}</td>
                                    <td>
                                        @if ($student->photo !== null && $student->photo !== '')
                                            <img src="/uploads/{{ $student->photo }}" alt="{{ $student->name }}" class="img-radius wid-40 align-top m-r-15">
                                        @endif
                                        <div class="d-inline-block">
                                            <h6>{{ $student->name }}</h6>
                                        </div>
                                    </td>
                                    <td>{{ $student->class_of }}</td>
                                    <td>{{ date("d F Y", strtotime($student->period)) }}</td>
                                    <td>
                                        <a href="{{ route("student.activity.details") }}?search_text={{ $student->name }}&search_status=1" class="badge badge-primary">Open <span class="badge badge-light">{{ $student->open }}</span></a>
                                        <a href="{{ route("student.activity.details") }}?search_text={{ $student->name }}&search_status=2" class="badge badge-info">Review <span class="badge badge-light">{{ $student->review }}</span></a>
                                        <a href="{{ route("student.activity.details") }}?search_text={{ $student->name }}&search_status=3" class="badge badge-success">Approve <span class="badge badge-light">{{ $student->approve }}</span></a>
                                        <a href="{{ route("student.activity.details") }}?search_text={{ $student->name }}&search_status=4" class="badge badge-danger">Reject <span class="badge badge-light">{{ $student->reject }}</span></a>
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

                {{ $students->links('vendor.pagination.custom-default') }}
            </div>
        </div>

        <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Approve Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Periksa kembali kesesuaian data.
                            <br>
                            Apakah anda yakin akan memproses data tersebut?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="button" class="btn  btn-primary" id="btn-ya" data-id="" data-dismiss="modal">Ya</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="exampleModalAlert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalAlertTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalAlertTitle">Approve Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal(this)"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Terjadi kesalahan, data mahasiswa tidak ditemukan.
                            <br>
                            Silahkan coba lagi!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-primary" data-dismiss="modal" onclick="closemodal(this)">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.showmodal = function (id) {
            $("#btn-ya").data("id", id);
        }

        window.closemodal = function (th) {
            $("#exampleModalAlert").removeClass("show");
            $("#exampleModalAlert").css({"display":"none"});
        }

        $("#btn-ya").on("click", function(){
            var id = $(this).data("id");

            var ajaxurl = "{{ route('student.approve-certificate') }}";
            $.ajax({
                url: ajaxurl, 
                type: "POST", 
                data: {
                    _token : '{{ csrf_token() }}',
                    id : id,
                },
                success: function(data) {
                    if(data.status == 'ok') {
                        $("#crtf-td-"+ id +"").html(`<span style="color: #1abc9c;"><i class="feather icon-check" title="Approved"></i></span>`);
                    } else {
                        $("#exampleModalAlert").addClass("show");
                        $("#exampleModalAlert").css({"display":"block"});
                    }
                }, 
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

@endsection