<!-- Fonts and Styles -->
@yield('css_before')
<!-- Stylesheets -->
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/cropperjs/cropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/doka/doka.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/filepond/filepond-plugin-image-edit/filepond-plugin-image-edit.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/filepond/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/summernote/summernote-bs4.css') }}">


<link rel="stylesheet" id="css-main" href="{{ asset('css/fonts.css') }}">
<link rel="stylesheet" id="css-theme" href="{{ mix('css/dashmix.css') }}">

<!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
<link rel="stylesheet" href="{{ mix('css/themes/' . env('THEME_CSS') . '.css') }}">

@yield('css_after')
