@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Attendance Report - Form',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Attendance Report Form',
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
    @include('layouts._panels_start_column', ['size' => 8])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Report Type', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New quarter dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'quarter_id',
        'label' => 'Quarter',
        'array' => $quarters,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->

    <!----------------------------------------------------------------------------->
    <!---------------------------New class dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'class_id',
        'label' => 'Class',
        'array' => $classes,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->
    {!! JsValidator::formRequest('\App\Http\Requests\StoreAttendanceQuarterlyReportRequest','#admin-form') !!}

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            $("#class_id").select2({ placeholder: "Choose One..." });


        });
    </script>
@endsection
