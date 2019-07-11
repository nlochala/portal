@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Family Dashboard',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Family Dashboard',
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

    @for($i = 0; $i < $students->count(); $i++)
        @include('layouts._panels_start_row',['has_uniform_length' => false])
        @include('layouts._panels_start_column', ['size' => 6])
        @if ($students[$i] instanceof App\Student)
            @include('student._info_panel', ['student' => $students[$i]])
        @endif
        @include('layouts._panels_end_column')
        @include('layouts._panels_start_column', ['size' => 6])
        @if ($guardians[$i] instanceof App\Guardian)
            @include('guardian._info_panel', ['guardian' => $guardians[$i]])
        @endif
        @include('layouts._panels_end_column')
        @include('layouts._panels_end_row')
    @endfor
    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {


        });
    </script>
@endsection