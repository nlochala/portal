@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'New Person',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => '+ Add New Person',
            'page_uri'  => '/person/create'
        ]
    ]
])

    @include('layouts._content_start')

    <!--
    panel.row
    panel.panel
    panel.panel
-->
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 8])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'New Person'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['id' => 'admin-form','url' => 'person/create']) !!}


    @include('person._create_form')


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
    <script type="text/javascript">
        jQuery(document).ready(function () {

            $("#title").select2({ placeholder: "Choose one...", });
            $("#country_of_birth_id").select2({ placeholder: "Choose One..." });
            $("#language_primary_id").select2({ placeholder: "Choose One..." });
            $("#language_secondary_id").select2({ placeholder: "Choose One..." });
            $("#language_tertiary_id").select2({ placeholder: "Choose One..." });
            $("#ethnicity_id").select2({ placeholder: "Choose One..." });
            $("#dob").datepicker();

            @include('person.js_validation')
        });
    </script>
@endsection
