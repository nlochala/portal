@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Teacher Dashboard',
    'breadcrumbs' => [
        [
            'page_name' => 'App',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Teacher Dashboard',
            'page_uri'  => '/teacher_dashboard'
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

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Test'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['id' => 'admin-form','url' => 'person/create']) !!}
    @include('layouts._forms._heading',['title' => 'New Person Type'])
    @include('layouts._forms._row_start', ['size' => 12])

{{--    @include('person._create_form')--}}

    @include('layouts._forms._row_end')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
{{--    @include('layouts._panels_end_column')--}}
{{--    @include('layouts._panels_start_column', ['size' => 6])--}}
{{--    <!-------------------------------------------------------------------------------->--}}
{{--    <!----------------------------------New Panel ------------------------------------>--}}
{{--    @include('layouts._panels_start_panel', ['title' => 'Test 2'])--}}
{{--    --}}{{-- START BLOCK OPTIONS panel.block --}}
{{--    @include('layouts._panels_start_content')--}}

{{--    Blah Blah!--}}

{{--    @include('layouts._panels_end_content')--}}
{{--    @include('layouts._panels_end_panel')--}}
{{--    <!-------------------------------------------------------------------------------->--}}
{{--    <!-------------------------------------------------------------------------------->--}}
{{--    @include('layouts._panels_end_column')--}}
{{--    @include('layouts._panels_start_column', ['size' => 12])--}}
{{--    <!-------------------------------------------------------------------------------->--}}
{{--    <!----------------------------------New Panel ------------------------------------>--}}
{{--    @include('layouts._panels_start_panel', ['title' => 'Test 3'])--}}
{{--    --}}{{-- START BLOCK OPTIONS panel.block --}}
{{--    @include('layouts._panels_start_content')--}}

{{--    Blah Blah!--}}

{{--    @include('layouts._panels_end_content')--}}
{{--    @include('layouts._panels_end_panel')--}}
{{--    <!-------------------------------------------------------------------------------->--}}
{{--    <!-------------------------------------------------------------------------------->--}}
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')





    @include('layouts._content_end')
@endsection