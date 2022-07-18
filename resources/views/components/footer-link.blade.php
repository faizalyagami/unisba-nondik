<!-- Required Js -->
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>

{{-- <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script> --}}

<!-- Apex Chart -->
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>

<!-- custom-chart js -->
<script src="{{ asset('assets/js/pages/dashboard-main.js') }}"></script>

<script>
    window.fileUpload = function (th) {
        var i = $(th).prev('label').clone();
        var file = $('#photo')[0].files[0].name;
        $(th).prev('label').text(file);
    };
</script>