@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'New Message',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Dashboard',
            'page_uri'  => '/message/dashboard'
        ],
        [
            'page_name' => 'New Message',
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
    @include('layouts._panels_start_column', ['size' => 10])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'New Message', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New class_id[] dropdown----------------------------->
    @include('layouts._forms._input_dropdown_multiple',[
        'name' => 'class_id',
        'label' => 'Message Recipients',
        'array' => $class_dropdown,
        'class' => null,
        'selected' => null, // []
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New subject text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'subject',
        'label' => 'Subject',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!------------------------New message_body textarea field---------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'message_body-edit',
        'label' => 'Message',
        'placeholder' => '',
        'required' => true
      ])

    {!! Form::hidden('message_body', null,['id' => 'message_body']) !!}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
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

    <!-- Add Form Validation v.blade -->
    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianMessageRequest','#admin-form') !!}

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
// Init Select2 - Basic Multiple
            $("#class_id").select2({
                placeholder: "Select one or more recipients...",
                allowClear: true,
                width: '100%'
            });

            var edit_element = $('#message_body-edit');
            var input_element = $('#message_body');
            var form_element = $('#admin-form');
            var error_text = '<p><span style="color: rgb(224, 79, 26); font-size: 14px;">The message is required.</span></p>';

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
                        if(content == error_text){
                            edit_element.summernote('code', '');
                        }
                    }
                }
            });

            form_element.on('submit', function (e) {
                if (edit_element.summernote('isEmpty')) {
                    edit_element.summernote('code',error_text);
                    e.preventDefault();
                }
            });

// IF THERE IS EXISTING TEXT TO PASS THROUGH
            text_data = '{!! old('message_body') ?? '' !!}';
            edit_element.summernote('code', text_data);




        });
    </script>
@endsection
