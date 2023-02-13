<link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">

<style>
    @font-face {
        font-family: 'bellezac';
        src: url('../assets/fonts/Belleza-Regular.ttf')
    }

    @font-face {
        font-family: 'rasa-medium';
        src: url('../assets/fonts/Rasa-Medium.ttf')
    }
    @font-face {
        font-family: 'tttsars';
        src: url('../assets/fonts/TTTsars.ttf')
    }
    @font-face {
        font-family: 'greatvibes';
        src: url('../assets/fonts/great-vibes.regular.ttf')
    }
    html, body {
        margin: 0;
        padding: 0;
        font-family: 'rasa-medium', 'Poppins', 'Trebuchet Ms', arial;
        background: #eee;
    }
    .packing-label {
        display: block;
        z-index: 999999;
        width: 100%;
        background: #eee;
        color: #334166
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
        max-width: 1000px;
        height: 707px;
        outline: none;
        background-image: url('/assets/images/profile/certificate-2.png1');
        background-size: cover;
    }
    .packing-label .pl-area .pl-content {
        display: block;
        /* border-bottom: .05em dashed #000; */
        box-sizing: border-box;
        padding: 10px;
        font-family: 'rasa-medium', 'Poppins', 'Trebuchet Ms', arial;
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
        color: #334166;
    }

    .title-certificate {
        font-family: bellezac;
        font-size: 49px;
        letter-spacing: -1.3;
        font-weight: 100;
    }
    .packing-label .pl-area .pl-content table tr td label {
        font-size: 33px;
        padding-top: 10px;
        padding-bottom: 15px;
        display: inline-block;
    }
    .tahun {
        font-size: 21px;
        padding-top: 10px;
        padding-bottom: 10px;
        display: inline-block;
        color: #000;
    }
    .nama {
        font-family: greatvibes;
        font-size: 109px;
        padding-top: 37px;
        padding-bottom: 15px;
        display: inline-block;
        color: #03989e;
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
        color: #865b34;;
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
        font-size: 13px;
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
    table {
        margin-top: 12px;
    }
    table tr td{
        text-align: center;
        color: #865b34;
    }

</style>

<div class="packing-label">
    <div class="pl-head">
        <strong>Certificate</strong>
        <div>
            <a href="{{ route('profile.generate-pdf') }}">Download PDF</a>
            <a href="javascript:void(0)" onclick="window.print()">Print Sekarang</a>
            <a href="{{ route('home') }}">Keluar</a>
        </div>
    </div>
    <div class="pl-area">
        <form action="" class="form-main" id="form-create-pickpack" method="post" enctype="multipart/form-data" style="position: relative;">
            <div style="position: absolute;">
                <img width="100%" class="img-fluid d-block w-10" src="{{ asset("assets/images/profile/certificate-2.png") }}" alt="">
            </div>
            <div class="pl-content" style="    position: absolute; top: 0; text-align: center; width: 100%;">
                @php($path = route("student.show", [$student->npm]) )
                <p>
                    <div style="text-align: center; margin-top: 126px; font-size: 41px; font-family: bellezac;">SERTIFIKAT SKS NON AKADEMIK</div>
                    <div style="text-align: center; font-family: tttsars; font-size: 25px; color: #865b34; margin-top: 8px;"> NOMOR: {{ sprintf("%'.03d", $student->order) }}/SNA/PSI/{{ $month_rome }}/{{ $current_year }}</div>
                    <div style="text-align: center; margin-top: 16px; font-size: 28px;">Diberikan Kepada:</div>
                    <div style="text-align: center; margin-top: 2px; font-family: greatvibes; color: #03989e; font-size: 68px;">{{ $student->name }}</div>
                    <div style="text-align: center; font-size: 30px; margin-top: 15px;">
                        NPM: {{ $student->npm }}
                    </div>
                    <div style="position: absolute; top: 405px; margin-left: 839px;">{!! DNS2D::getBarcodeHTML($path, 'QRCODE', 3, 3) !!}</div>
                    <div style="text-align: center; font-size: 17px; margin-top: 9px;">
                        yang telah aktif berkegiatan dalam bidang non-akademik selama masa perkuliahan di
                    </div>
                    <div style="text-align: center; font-size: 17px; margin-top: 3px;">
                        @if ($achievement !== null && $achievement->sks !== null)
                            {!! 'Fakultas Psikologi Unisba, dengan perolehan skor '. $achievement->sks .' SKS dan mendapat predikat <span style="text-transform: uppercase;">'. $result .'</span>'!!}
                        @else
                            Fakultas Psikologi Unisba, dengan perolehan skor 0 SKS dan mendapat predikat Belum Cukup
                        @endif
                    </div>
                    <div style="text-align: center; font-size: 21px; margin-top: 22px;">Bandung, {{ $date }}</div>
                    @if($student->certificate_approve == 1)
                        <div style="position: absolute; top: 521px; margin-left: 107px;">
                            <img width="231px" class="img-fluid d-block w-10" src="{{ asset("assets/images/wadek-3.png") }}" alt="">
                        </div>
                    @endif
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            
                            <td>
                                <div style="font-size: 15px; letter-spacing: -0.01;">Wakil Dekan III</div>
                                <div style="font-size: 15px; letter-spacing: -0.01; margin-top: 2px;">Fakultas Psikologi Unisba</div>
                                <div style="font-size: 19px; letter-spacing: -0.01; margin-top: 78px; color: #334166;">Suhana, M.Psi., Psikolog</div>
                                <div style="font-size: 15px; letter-spacing: -0.01; margin-top: 8px;">NIP. D.00.0.329</div>
                            </td>
                            <td width="35"></td>
                            <td>
                                <div style="font-size: 15px;">Ketua Pansus</div>
                                <div style="font-size: 15px; letter-spacing: -0.01; margin-top: 2px;">Periode {{ $year !== null ? $year->show : "" }}</div>
                                <div style="font-size: 19px; letter-spacing: -0.01; margin-top: 78px; color: #334166;">Firda Damayanti</div>
                                <div style="font-size: 15px; letter-spacing: -0.01; margin-top: 8px;">NPM: 10050019168</div>
                            </td>
                            <td width="65"></td>
                        </tr>
                    </table>
                </p>
            </div>
        </form>
    </div>
</div>

