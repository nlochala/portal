@extends('layouts.backend_guardian')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Guardian Dashboard',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Dashboard',
            'page_uri'  => request()->getRequestUri()
        ]
    ]
])
    @include('layouts._content_start')

    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel
    panel.row

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 6])
    @include('guardian._info_panel')
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 6])
    @include('message._panel')
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
{{--
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Newsfeed', 'with_block' => false])
    --}}
{{-- START BLOCK OPTIONS panel.block --}}{{--

    @include('layouts._panels_start_content')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
--}}


    @include('layouts._content_end')

    @include('message._panel_modal')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->
    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianMessageRequest','#admin-form') !!}

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

            @include('message._panel_js')

        });
    </script>
@endsection
