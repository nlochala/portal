@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('guardian._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">Update Passport (#{{ $passport->number }})</h1>
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

    {!! Form::model($passport,['method' => 'PATCH','files' => true, 'id' => 'passport-form','url' => request()->getRequestUri()]) !!}

    @include('person._form_passport')

    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Passport Information Page'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <div class="options-container" style="text-align: center; padding-bottom: 15px">
        <img class="img-fluid options-item rounded border border-dark" src="{{ $passport->image->originalFile->renderImage() }}" alt="">
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
    {!! JsValidator::formRequest('\App\Http\Requests\UpdateGuardianPassportRequest','#passport-form') !!}

    <script type="text/javascript">
        @include('layouts._forms._js_filepond', ['id' => 'upload'])

        jQuery(document).ready(function () {
            $("#country_id").select2({placeholder: "Choose One..."});
            $("#expiration_date").datepicker();
            $("#issue_date").datepicker();
        });
    </script>
@endsection