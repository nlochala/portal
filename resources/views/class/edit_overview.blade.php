@extends('layouts.backend')

@section('content')
    @include('class._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{!! $class->fullName(true)!!} - Overview</h1>

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
    @include('layouts._panels_start_column', ['size' => 9])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Update', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'classes-form','url' => request()->getRequestUri()]) !!}
    @include('class._class_form')
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
    {!! JsValidator::formRequest('\App\Http\Requests\StoreClassRequest','#classes-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#primary_employee_id").select2({ placeholder: "Choose One..." });
            $("#secondary_employee_id").select2({ placeholder: "Choose One...", allowClear: true });
            $("#ta_employee_id").select2({ placeholder: "Choose One...", allowClear: true });
            $("#course_id").select2({ placeholder: "Choose One..." });
            $("#room_id").select2({ placeholder: "Choose One..." });

            // on button click
        });
    </script>
@endsection
