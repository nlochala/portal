@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $course->full_name,
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
    @include('layouts._panels_start_panel', ['title' => 'Overview', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <span class="badge badge-primary"><i class="fa fa-book-open"></i> ID: {{ $course->id }}</span>
    @if($course->is_active)
        <span class="badge badge-success"><i class="fa fa-check-circle"></i> ACTIVE - {{ $course->year->name }}</span>
    @else
        <span class="badge badge-dark"><i class="fa fa-minus-circle"></i> INACTIVE - {{ $course->year->name }}</span>
    @endif
    @include('_tables.new-table',['class' => 'table-borderless', 'id' => 'overview_table', 'table_head' => ['','']])
    <tr>
        <td><strong>Abbreviation:</strong> {{ $course->short_name }}</td>
        <td><strong>Name:</strong> {{ $course->name }}</td>
    </tr>
    <tr>
        <td><strong>Description:</strong> {{ $course->description }}</td>
        <td><strong>School Year:</strong> {{ $course->year->name}}</td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td><strong>Created By:</strong> {{ $course->createdBy->person->fullName() }} on {{ $course->created_at }}</td>
    </tr>
    <tr>
        <td><strong>Last Updated By:</strong> {{ $course->updatedBy->person->fullName() }} on {{ $course->updated_at }}
        </td>
    </tr>
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Options', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <button type="button" dusk="btn-modal-block-classes" class="btn btn-outline-secondary mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-classes" style="width: 100%">
        <i class="fa fa-user-friends"></i> Associated Classes
    </button>
    <button type="button" dusk="btn-modal-block-materials" class="btn btn-outline-secondary mr-1 mb-3"
            data-toggle="modal"
            data-target="#modal-block-materials" style="width: 100%">
        <i class="fa fa-book"></i> Required Materials
    </button>
    <button type="button" dusk="btn-modal-block-prerequisites" class="btn btn-outline-info mr-1 mb-3"
            data-toggle="modal"
            data-target="#modal-block-prerequisites" style="width: 100%">
        <i class="fa fa-list"></i> Prerequisite Courses
    </button>
    <button type="button" dusk="btn-modal-block-corequisites" class="btn btn-outline-info mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-corequisites" style="width: 100%">
        <i class="fa fa-list"></i> Corequisite Courses
    </button>
    <button type="button" dusk="btn-modal-block-equivalent" class="btn btn-outline-info mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-equivalent" style="width: 100%">
        <i class="fa fa-list"></i> Equivalent Courses
    </button>
    <button type="button" dusk="btn-modal-block-audit" class="btn btn-outline-danger mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-audit" style="width: 100%">
        <i class="fa fa-clipboard-list"></i> Audit Changes
    </button>
    <button type="button" dusk="btn-modal-block-edit" class="btn btn-outline-danger mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-edit" style="width: 100%">
        <i class="fa fa-pen"></i> Edit
    </button>
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Report Card', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'report-card-form','url' => request()->getRequestUri().'/report_card_options']) !!}
    <!----------------------------------------------------------------------------->
    <!-----------------------New report_card checkbox------------------------------------->
    <div class="form-group">
        <label>Report Card Options</label>
    @foreach($report_card_checkbox as $name => $description)
            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" id="{{ $name }}" name="{{ $name }}" {{ \App\Helpers\Helpers::isChecked($course->$name) }}>
                <label class="custom-control-label" for="{{ $name }}">{{ $description }}</label>
            </div>
    @endforeach
    </div>
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
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
    @include('layouts._panels_start_panel', ['title' => 'Transcript', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    transcript

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Scheduling', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    scheduling

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
    <!-------------------------------- Modal: Associated Classes Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-classes',
        'title' => 'Associated Classes'
    ])

    <!-- TABLE OF CLASSES -->@include('_tables.new-table',['id' => 'classes_table', 'table_head' => ['ID', 'Name', 'Age Level', 'Enrolled', 'Teacher']])
    @include('_tables.end-new-table')

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Associated Classes END------------------------------------------->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {


        });
    </script>
@endsection