@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Report Cards - Print Form',
    'subtitle' => $year->name.' - <small><em><a data-toggle="modal" data-target="#modal-block-date" href="#modal-block-date">Change Year</a></em></small>',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Print Form',
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
    @include('layouts._panels_start_panel', ['title' => 'Print Form', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => '/report/report_cards/'.$year->uuid.'/print']) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New quarter_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'quarter_id',
        'label' => 'Quarter',
        'array' => $quarter_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New grade_level_id[] dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'grade_level',
        'label' => 'Grade Level',
        'array' => $grade_levels,
        'class' => null,
        'selected' => null, // []
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

    <!-------------------------------- Modal: Years Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-date',
        'title' => 'Years'
    ])

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New year dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'year',
        'label' => 'Select Year',
        'array' => $years_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Years END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-date". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            $("#grade_levels").select2({placeholder: "Choose Multiple..."})


        });
    </script>
@endsection
