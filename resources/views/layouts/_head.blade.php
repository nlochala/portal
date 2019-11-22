<head>
@include('layouts._meta')
<!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">
@include('.layouts._css')
<!-- Scripts -->
    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    <input type="hidden" id="authenticated_user_uuid" value="{{ auth()->user()->uuid ?? '' }}" />
    <input type="hidden" id="authenticated_user_id" value="{{ auth()->user()->id ?? '' }}" />
</head>
