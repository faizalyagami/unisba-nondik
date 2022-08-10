<style>
    html, body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', 'Trebuchet Ms', arial;
        background: #eee;
    }
    .packing-label {
        display: block;
        z-index: 999999;
        width: 100%;
        background: #eee;
    }
    .packing-label form {
        margin: 0;
        padding: 0;
    }
    .packing-label .pl-head {
        display: block;
        width: 100%;
        height: 34px;
        background: #fff;
        /* border-bottom: 1px solid #ddd; */
        position: fixed;
        top: 0;
        left: 0;
    }
    .packing-label .pl-head strong {
        float: left;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 34px;
        padding: 0 10px;
    }
    .packing-label .pl-head div {
        float: right;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 34px;
        padding: 0 10px;
    }
    .packing-label .pl-head a,
    .packing-label .pl-head .pl-close {
        display: inline-block;
        color: #fff;
        background: #ce007c;
        background: -moz-linear-gradient(90deg, #ce007c 0%, #ed1c49 100%);
        background: -webkit-linear-gradient(90deg, #ce007c 0%, #ed1c49 100%);
        background: linear-gradient(90deg, #ce007c 0%, #ed1c49 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ce007c", endColorstr="#ed1c49", GradientType=1);
        padding: 5px 10px;
        margin-left: 3px;
        font-size: 12px;
        text-decoration: none;
        text-transform: uppercase;
        -webkit-transition: all 0.2s ease-out 0s;
        -moz-transition: all 0.2s ease-out 0s;
        -ms-transition: all 0.2s ease-out 0s;
        -o-transition: all 0.2s ease-out 0s;
        transition: all 0.2s ease-out 0s;
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        filter: grayscale(100%);
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .packing-label .pl-head a:hover,
    .packing-label .pl-head .pl-close:hover {
        -webkit-filter: grayscale(0);
        -moz-filter: grayscale(0);
        filter: grayscale(0);
        cursor: pointer;
    }
    .packing-label .pl-area {
        display: table;
        margin: auto;
        margin-top: 40px;
        background: #fff;
        width: 100%;
        max-width: 11.69in;
        height: 7.28in;
        outline: none;
    }
    .packing-label .pl-area .pl-content {
        display: block;
        /* border-bottom: .05em dashed #000; */
        box-sizing: border-box;
        padding: 10px;
        font-family: 'Poppins', 'Trebuchet Ms', arial;
    }
    .packing-label .pl-area .pl-content table {
        width: 100%;
        /* border-left: .03em solid #000; */
        /* border-top: .03em solid #000; */
        outline: none;
    }
    .packing-label .pl-area .pl-content table tr td {
        /* border-right: .03em solid #000; */
        /* border-bottom: .03em solid #000; */
        padding: 4px;
        font-size: 17px;
        vertical-align: top;
        line-height: 9px;
        /* text-transform: uppercase; */
        outline: none;
        color: #000;
    }
    .packing-label .pl-area .pl-content table tr td label {
        font-size: 33px;
        font-weight: bolder;
        padding-top: 10px;
        padding-bottom: 15px;
        display: inline-block;
        color: #03b3a4;
    }
    .tahun {
        font-size: 21px;
        font-weight: bolder;
        padding-top: 10px;
        padding-bottom: 10px;
        display: inline-block;
        color: #000;
    }
    .nama {
        font-size: 29px;
        font-weight: bold;
        padding-top: 10px;
        padding-bottom: 15px;
        display: inline-block;
        text-transform: uppercase;
        color: #000;
    }
    .packing-label .pl-area .pl-content table tr td img {
        display: block;
        width: 100%;
        height: auto;
    }
    .packing-label .pl-area .pl-content table tr td svg {
        height: 21px;
        width: auto;
        margin: 17px 10px;
    }
    .packing-label .pl-area .pl-content table tr td div {
        font-size: 8px;
        padding-top: 5px;
        color: #000;
        letter-spacing: .075em;
    }
    .packing-label .pl-footer {
        display: block;
        position: fixed;
        background: #fff;
        /* border-top: 1px solid #ddd; */
        bottom: 0;
        left: 0;
        box-sizing: border-box;
        padding: 10px;
        font-size: 10px;
        width: 100%;
    }
    .ttd {
        line-height: 15px !important;
        font-weight: bold;
    }
    @media print {
        body {
            overflow: auto;
        }
        .packing-label {
            background: #fff;
        }
        .packing-label .pl-head {
            display: none;
        }
        .packing-label .pl-area {
            margin-top: 0;
            margin: 0 inherit;
            left: 0;
        }
        .packing-label .pl-footer { display: none; }
    }
</style>

<div class="packing-label">
    <div class="pl-head">
        <strong>Certificate</strong>
        <div>
            <a href="javascript:void(0)" onclick="window.print()">Print Sekarang</a>
            <a href="{{ route('home') }}">Keluar</a>
        </div>
    </div>
    <div class="pl-area">
        <form action="" class="form-main" id="form-create-pickpack" method="post" enctype="multipart/form-data" style="background-image: url('/assets/images/profile/14140293_5439231.png');background-size: cover;">
            <div class="pl-content">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="4" align="center" style="vertical-align:middle;padding-left:20px;padding-right:15px; height: 75px">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="height: 75px"></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <label>SERTIFIKAT SKS NON AKADEMIK</label><br>
                            <span class="tahun"> Tahun Akademik {{ $year !== null ? $year->show : "" }}</span><br>
                            <span class="tahun"> diberikan kepada </span><br><br><br>
                            <span class="nama">{{ $student->name }}</span><br>
                            <span class="nama">{{ $student->npm }}</span><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="height: 35px"></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="vertical-align:middle;padding: 5px 0 5px 0;">
                            yang telah aktif berkegiatan dalam bidang non akademik selama perkuliahan,
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="vertical-align:middle;padding: 5px 0 5px 0;">
                            @if ($achievement !== null && $achievement->sks !== null)
                                {{ 'dengan perolehan skor '. $achievement->sks .' SKS dan mendapatkan predikat '. $result }}
                            @else
                                dengan perolehan skor 0 SKS dan mendapatkan predikat Belum Cukup
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="font-weight: bold;padding: 10px 0 10px 0;">Bandung, {{ $date }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="145px">&nbsp;</td>
                        <td colspan="" align="center" class="ttd">
                            Wakil Dekan III
                            <br>
                            Fakultas Psikologi Unisba
                            <br><br><br><br><br>
                            <br><br><br><br><br>
                            Suhana, S.Psi., M.Psi., Psikolog
                            <hr style="width: 213px;">
                            NIK. D.00.0.329
                            <br>
                        </td>
                        <td colspan="" align="center" class="ttd">
                            Ketua Pansus
                            <br>
                            Periode {{ $year !== null ? $year->show : "" }}
                            <br><br><br><br><br>
                            <br><br><br><br><br>
                            Disa Aurea Annisa Nureffa
                            <hr style="width: 213px;">
                            NPM. 10050018146
                            <br>
                        </td>
                        <td width="145px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center" style="height: 40px"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>

