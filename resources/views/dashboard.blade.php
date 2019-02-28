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
    panel.panel
    panel.panel
-->
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    <!-------------------------------------------------------------------------------->
    <!------------------------------New Panel --------------------------------->
    @include('layouts._panels_start_panel', ['title' => 'Test 1', 'size' => 12])
    {{-- START BLOCK OPTIONS --}}
    <div class="block-options">
        <button type="button" class="btn-block-option">
            <i class="fa fa-fw fa-pencil-alt"></i>
        </button>
    </div>
    {{-- END BLOCK OPTIONS --}}
    @include('layouts._panels_start_content')

    Hello Content!!

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    <!------------------------------New Panel --------------------------------->
    @include('layouts._panels_start_panel', ['title' => 'Test 2', 'size' => 12])
    {{-- START BLOCK OPTIONS --}}
    <div class="block-options">
        <button type="button" class="btn-block-option">
            <i class="fa fa-fw fa-pencil-alt"></i>
        </button>
    </div>
    {{-- END BLOCK OPTIONS --}}
    @include('layouts._panels_start_content')

    Hello Right Content!

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_row')


{{ get_class(new Request) }}



    @include('layouts._content_end')
@endsection