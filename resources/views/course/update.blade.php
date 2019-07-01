@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $course->short_name.' - Edit',
    'subtitle' => $course->description,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Course Index',
            'page_uri'  => '/course/index'
        ],
        [
            'page_name' => $course->full_name,
            'page_uri'  => '/course/'.$course->uuid
        ],
        [
            'page_name' => $course->short_name.' - Edit',
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
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Edit', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($course,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    @include('course._course_form', ['type' => 'update'])
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

    {!! JsValidator::formRequest('\App\Http\Requests\StoreCourseRequest','#course-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
        });
    </script>
@endsection
