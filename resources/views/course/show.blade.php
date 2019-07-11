@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $course->full_name.' ('.$course->type->name.')',
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
        <td><strong>Abbreviation:</strong> {{ $course->short_name }} ({{ $course->type->name }})</td>
        <td><strong>School Year:</strong> {{ $course->year->name}}</td>
    </tr>
    <tr>
        <td><strong>Name:</strong> {{ $course->name }}</td>
        <td><strong>Prerequisites:</strong> {!! $course->display_inline_prerequisites !!}</td>
    </tr>
    <tr>
        <td><strong>Grade Levels:</strong> {{ $course->display_inline_grade_levels }}</td>
        <td><strong>Corequisites:</strong> {!! $course->display_inline_corequisites !!}</td>
    </tr>
    <tr>
        <td><strong>Max Class Size:</strong> {{ $course->max_class_size }}</td>
        <td><strong>Equivalent Courses:</strong> {!! $course->display_inline_equivalents !!}</td>
    </tr>
    <tr>
        <td><strong>Description:</strong> {{ $course->description ?? 'N/A' }}</td>
        <td><strong>Department: {{$course->department->name}}</strong></td>
    </tr>
    @include('_tables.end-new-table')
    <div class="btn-group">
        <button type="button" dusk="btn-modal-block-edit" class="btn btn-outline-danger mr-1 mb-3"
                data-toggle="modal"
                data-target="#modal-block-edit">
            <i class="fa fa-pen"></i> Edit Overview
        </button>
        <button type="button" dusk="btn-modal-block-audit" class="btn btn-outline-danger mr-1 mb-3"
                onclick="window.location.href='/course/{{ $course->uuid }}/audits'">
            <i class="fa fa-clipboard-list"></i> Audit Changes
        </button>
    </div>

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
    <div class="btn-group-vertical" style="width: 100%">
        <button type="button" dusk="btn-modal-block-classes" class="btn btn-outline-secondary mr-1 mb-3"
                data-toggle="modal"
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
        <button type="button" dusk="btn-modal-block-corequisites" class="btn btn-outline-info mr-1 mb-3"
                data-toggle="modal"
                data-target="#modal-block-corequisites" style="width: 100%">
            <i class="fa fa-list"></i> Corequisite Courses
        </button>
        <button type="button" dusk="btn-modal-block-equivalents" class="btn btn-outline-info mr-1 mb-3"
                data-toggle="modal"
                data-target="#modal-block-equivalents" style="width: 100%">
            <i class="fa fa-list"></i> Equivalent Courses
        </button>
    </div>
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
    @include('layouts._panels_start_panel', ['title' => 'Course Options', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'report-card-form','url' => request()->getRequestUri().'/report_card_options']) !!}
    <!----------------------------------------------------------------------------->
    <!-----------------------New report_card checkbox------------------------------------->
    <div class="form-group">
        <label>Display and Reporting Options</label>
        @foreach($report_card_checkbox as $name => $description)
            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" id="{{ $name }}"
                       name="{{ $name }}" {{ \App\Helpers\Helpers::isChecked($course->$name) }}>
                <label class="custom-control-label" for="{{ $name }}">{{ $description }}</label>
            </div>
        @endforeach
    </div>
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close_sm')
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

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::model($course,['method' => 'PATCH','files' => false, 'id' => 'transcript-form','url' => request()->getRequestUri().'/transcript_options']) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New credits text field----------------------------->
    @include('layouts._forms._input_text_sm',[
        'name' => 'credits',
        'label' => 'Credits',
        'placeholder' => '',
        'required' => false
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New course_transcript_type dropdown----------------------------->
    @include('layouts._forms._input_dropdown_sm',[
        'name' => 'course_transcript_type_id',
        'label' => 'Options',
        'array' => $transcript_types_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close_sm')
    <!-- END FORM----------------------------------------------------------------------------->

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
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($course,['method' => 'PATCH','files' => false, 'id' => 'scheduling-form','url' => request()->getRequestUri().'/scheduling_options']) !!}
    <!---------------------------New max_class_size text field----------------------------->
    @include('layouts._forms._input_text_sm',[
        'name' => 'max_class_size',
        'label' => 'Max Class Size',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New grade_levels[] dropdown----------------------------->
    @include('layouts._forms._input_dropdown_multiple_sm',[
        'name' => 'grade_levels',
        'label' => 'Grade Levels',
        'array' => $grade_level_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close_sm')
    <!-- END FORM----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')

    @include('course._show_modals')

@endsection

@section('js_after')

    {!! JsValidator::formRequest('\App\Http\Requests\StoreCourseSchedulingRequest','#scheduling-form') !!}
    {!! JsValidator::formRequest('\App\Http\Requests\StoreCourseTranscriptRequest','#transcript-form') !!}
    {!! JsValidator::formRequest('\App\Http\Requests\StoreCourseRequest','#edit-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#course_transcript_type_id").select2({placeholder: "Choose One..."});
            $("#grade_levels").select2({placeholder: "Choose One..."});

            $('#grade_levels').val([{{ implode(',', $course->gradeLevels->pluck('id')->toArray()) }}]);
            $('#grade_levels').trigger('change'); // Notify any JS components that the value changed

                    @include('course._requisites_datatables', ['type' => 'prerequisite'])
                    @include('course._requisites_datatables', ['type' => 'corequisite'])
                    @include('course._requisites_datatables', ['type' => 'equivalent'])

            var edit_element = $('#materials-edit');
            var input_element = $('#materials');
            var form_element = $('#materials-form');
            var error_text = '<p><span style="color: rgb(224, 79, 26); font-size: 14px;">The materials field is required.</span></p>';

            edit_element.summernote({
                toolbar: [
                    ['style'],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                    ['misc', ['undo', 'redo', 'fullscreen', 'help']]
                ],
                tabsize: 2,
                height: 400,
                dialogsInBody: true,
                dialogsFade: true,
                callbacks: {
                    onBlur: function () {
                        var content = edit_element.summernote('code');
                        input_element.val(content);
                    },
                    onFocus: function () {
                        var content = edit_element.summernote('code');
                        if (content == error_text) {
                            edit_element.summernote('code', '');
                        }
                    }
                }
            });

            form_element.on('submit', function (e) {
                // NOT A REQUIRED FIELD

                // if (edit_element.summernote('isEmpty')) {
                //     edit_element.summernote('code', error_text);
                //     e.preventDefault();
                // }
            });

            // IF THERE IS EXISTING TEXT TO PASS THROUGH
            text_data = '{!! old('materials') ?? $course->required_materials !!}';
            edit_element.summernote('code', text_data);

        });
    </script>
@endsection
