@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Guardian Welcome Letters',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Guardians Index',
            'page_uri'  => '/guardian/index'
        ],
        [
            'page_name' => 'Welcome Letters',
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
    <strong>NOTE: You have three options. You can choose to print out letters by class, grade, or student. For example, if you want
     to print out all the parent welcome letters for the 5th grade, select 5th Grade from the Grade Level dropdown and click
     on submit.</strong>
    <br />
    <br />
    <br />

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New student_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'student_id',
        'label' => 'Student',
        'array' => $student_dropdown,
        'class' => null,
        'selected' => null,
        'required' => false
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New grade_level_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'grade_level_id',
        'label' => 'Grade Level',
        'array' => $grade_level_dropdown,
        'class' => null,
        'selected' => null,
        'required' => false
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New class_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'class_id',
        'label' => 'Class',
        'array' => $class_dropdown,
        'class' => null,
        'selected' => null,
        'required' => false
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

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            $("#student_id").select2({ placeholder: "Choose One..." });
            $("#class_id").select2({ placeholder: "Choose One..." });
            $("#grade_level_id").select2({ placeholder: "Choose One..." });

        });
    </script>
@endsection
