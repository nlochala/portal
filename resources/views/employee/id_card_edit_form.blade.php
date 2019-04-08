@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('person._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">ID Card #xxxxxx{{ substr($id_card->number, -4) }}</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'ID Card', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($id_card,['method' => 'PATCH','files' => true, 'id' => 'id_card-form','url' => request()->getRequestUri()]) !!}
    @include('person._edit_form_id_card')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'ID Card Images', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <div class="options-container" style="text-align: center">
        <img class="img-fluid options-item rounded border border-2x border-dark"
             src="{{ $id_card->frontImage->renderImage() }}" alt="">
    </div>
    <hr/>
    <div class="options-container" style="text-align: center; padding-bottom: 25px">
        <img class="img-fluid options-item rounded border border-2x border-dark"
             src="{{ $id_card->backImage->renderImage() }}" alt="">
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
            $("#is_active").select2({placeholder: "Choose One..."});
            $("#issue_date").datepicker();
            $("#expiration_date").datepicker();

            @include('layouts._forms._js_validate_start')
            // Init Form Validation. form.js.validation.template
            jQuery('#id_card-form').validate({
                ignore: [],
                rules: {
                    'is_active': {
                        required: true
                    },
                    'number': {
                        required: true
                    },
                    'name': {
                        required: true
                    },
                    'issue_date': {
                        required: true
                    },
                    'expiration_date': {
                        required: true
                    }
                },
                messages: {}
            });
            @include('layouts._forms._js_validate_end')

        });
    </script>
@endsection