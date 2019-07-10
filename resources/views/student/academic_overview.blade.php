@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('student._horizontal_menu')
    @include('layouts._content_start')
        <h1 class="font-w400" style="text-align: center">{{ $student->person->fullName()}}'s Academic Overview</h1>
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

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Overview', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::model($student,['method' => 'PATCH','files' => false, 'id' => 'overview-form','url' => request()->getRequestUri()]) !!}
    @include('student._academic_overview_form')
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
    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentAcademicOverviewRequest','#overview-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#student_status_id").select2({ placeholder: "Choose One..." });
            $("#grade_level_id").select2({ placeholder: "Choose One..." });
            $("#start_date").datepicker();
            $("#end_date").datepicker();
        });
    </script>
@endsection