@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'EMPLOYEE: '.$employee->person->preferred_name.' '.$employee->person->family_name,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/',
        ],
        [
            'page_name' => 'Employee Dashboard',
            'page_uri'  => request()->getRequestUri(),
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
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 8])

    @include('employee._info_panel_large')

    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])

    @include('person._profile_image', ['person' => $employee->person])

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])

    @if($employee->id === auth()->user()->person->employee->id || auth()->user()->can('positions.show.positions'))
        @include('employee._position_information')
    @endif


    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @if ($employee->person->user)
        @include('layouts._panels_start_row',['has_uniform_length' => false])
        @include('layouts._panels_start_column', ['size' => 3])
        @include('user._ad_information', ['user' => $employee->person->user])
        @include('layouts._panels_end_column')
        @include('layouts._panels_start_column', ['size' => 9])
        @include('user._ad_groups', ['user' => $employee->person->user])
        @include('layouts._panels_end_column')
        @include('layouts._panels_end_row')
    @endif

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
