<!-- Fonts and Styles -->
@yield('css_before')
<link rel="stylesheet" id="css-main" href="{{ asset('css/fonts.css') }}">
<link rel="stylesheet" id="css-theme" href="{{ mix('css/dashmix.css') }}">

<!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
<link rel="stylesheet" href="{{ mix('css/themes/' . env('THEME_CSS') . '.css') }}">
@yield('css_after')

