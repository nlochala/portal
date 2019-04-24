@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'New Position',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => '+ New Position',
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
    @include('layouts._panels_start_panel', ['title' => 'Position Form', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- START FORM----------------------------------------------------------------------------->
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'position-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New name text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'name',
        'label' => 'Position Name',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New position_type_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'position_type_id',
        'label' => 'Position Type',
        'array' => $type_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New school_id radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'school_id',
        'label' => 'Area of Responsibility',
        'array' => $school_dropdown,
        'selected' => null,
        'required' => true
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New supervisor_position_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'supervisor_position_id',
        'label' => 'Supervising Position',
        'array' => $position_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New stipend text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'stipend',
        'label' => 'Stipend',
        'placeholder' => '',
        'required' => false
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New description-edit text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'description-edit',
        'label' => 'Description',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->

    {!! Form::hidden('description', null,['id' => 'description']) !!}
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
    {!! JsValidator::formRequest('\App\Http\Requests\StorePositionRequest','#position-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#position_type_id").select2({placeholder: "Choose One..."});
            $("#supervisor_position_id").select2({placeholder: "Choose One..."});

            var edit_element = $('#description-edit');
            var input_element = $('#description');
            var form_element = $('#position-form');
            var error_text = '<p><span style="color: rgb(224, 79, 26); font-size: 14px;">The description field is required.</span></p>';

            edit_element.summernote({
                toolbar: [
                    ['style'],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                    ['misc', ['undo', 'redo','codeview','help']]
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
                if (edit_element.summernote('isEmpty')) {
                    edit_element.summernote('code', error_text);
                    e.preventDefault();
                }
            });

            // IF THERE IS EXISTING TEXT TO PASS THROUGH
            text_data = '{!! old('description') !!}';
            edit_element.summernote('code', text_data);
        });
    </script>
@endsection