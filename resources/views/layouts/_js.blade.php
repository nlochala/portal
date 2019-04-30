{{--<!-- Dashmix Core JS -->--}}
<script src="{{ asset(mix('js/dashmix.app.js')) }}"></script>

{{--<!-- Laravel Scaffolding JS -->--}}
<script src="{{ asset(mix('js/laravel.app.js')) }}"></script>

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

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<!-- Filepond -->
<script src="{{ asset('js/plugins/doka/doka.min.js') }}"></script>

<!-- Filepond -->
<script src="{{ asset('js/plugins/filepond/filepond.js') }}"></script>

<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-encode/filepond-plugin-file-encode.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-metadata/filepond-plugin-file-metadata.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-crop/filepond-plugin-image-crop.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-edit/filepond-plugin-image-edit.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-preview/filepond-plugin-image-preview.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-resize/filepond-plugin-image-resize.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-transform/filepond-plugin-image-transform.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/filepond-plugin-image-validate-size/filepond-plugin-image-validate-size.js') }}"></script>
<script src="{{ asset('js/plugins/filepond/jquery-filepond/filepond.jquery.js') }}"></script>

<!-- Summernote Text Editor-->
<script src="{{ asset('js/plugins/summernote/summernote-bs4.min.js') }}"></script>


<script type="text/javascript">
    jQuery(document).ready(function () {
        @if(Session::has('color') && Session::has('icon') && Session::has('message') && Session::has('location') )
        Dashmix.helpers('notify', {
            from: '{{ Session::get('location')  }}',
            type: '{{ Session::get('color') }}',
            icon: '{{ Session::get('icon') }}',
            message: '{{ Session::get('message') }}'
        });
        @endif
    });
</script>