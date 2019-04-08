{{--<!-- Dashmix Core JS -->--}}
<script src="{{ mix('js/dashmix.app.js') }}"></script>

{{--<!-- Laravel Scaffolding JS -->--}}
<script src="{{ mix('js/laravel.app.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/plugins/cropperjs/cropper.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        @if(Session::has('color') && Session::has('icon') && Session::has('message') && Session::has('location') )
        Dashmix.helpers('notify', {from: '{{ Session::get('location')  }}', type: '{{ Session::get('color') }}', icon: '{{ Session::get('icon') }}', message: '{{ Session::get('message') }}'});
        @endif
    });
</script>