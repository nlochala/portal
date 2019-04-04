@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('person._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">Add New Passport</h1>
    <!--
    panel.row
    panel.column
    panel.panel

    panel.row
    panel.column
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
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 8])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Passport'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => true, 'id' => 'passport-form','url' => request()->getRequestUri()]) !!}

    @include('person._create_form_passport')

    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Example Passport Image'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <div class="options-container" style="text-align: center; padding-bottom: 20px">
        <img class="img-fluid options-item rounded border border-2x border-dark" src="{{ $image_data }}" alt="">
    </div>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
@endsection

@section('js_after')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#country_id").select2({placeholder: "Choose One..."});
            $("#expiration_date").datepicker();
            $("#issue_date").datepicker();

            @include('layouts._forms._js_validate_start')
            // Init Form Validation. form.js.validation.template
            jQuery('#passport-form').validate({
                ignore: [],
                rules: {
                    'is_cancelled': {
                        required: true
                    },
                    'country_id': {
                        required: true
                    },
                    'given_name': {
                        required: true
                    },
                    'family_name': {
                        required: true
                    },
                    'number': {
                        required: true
                    },
                    'issue_date': {
                        required: true
                    },
                    'expiration_date': {
                        required: true
                    },
                    'image_file': {
                        required: true
                    }
                },
                messages: {}
            });
            @include('layouts._forms._js_validate_end')
        });
    </script>
@endsection