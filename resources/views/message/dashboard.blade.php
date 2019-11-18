@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'All Messages',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => $class->fullName(),
            'page_uri'  => '/class/'.$class->uuid
        ],
        [
            'page_name' => 'Parent Messages',
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
    <button type="button" class="btn btn-hero-lg btn-hero-primary mr-1 mb-3"
    data-toggle="modal" data-target="#modal-block-new-message">
        <i class="fa fa-plus"></i> New Message
    </button>
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Messages', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF MESSAGES -->
    @if($messages->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else

        @include('_tables.new-table',['no_hover' => true, 'id' => 'message_table', 'table_head' => ['','From','Date Sent','Class','Subject', '']])
        @foreach($messages as $message)
            <tr>
                @if($message->is_read)
                    <td><i id="message_{{ $message->id }}_icon" class="si si-envelope-letter"></i></td>
                @else
                    <td><i id="message_{{ $message->id }}_icon" class="fa fa-circle" style="color: #0000cc"></i></td>
                @endif
                <td>{!! $message->from->name !!}</td>
                <td>{{ $message->createdAt }}</td>
                <td>{{ $message->class->fullName() }}</td>
                <td>{{ $message->subject }}</td>
                <td>
                    <a data-target="#message_{{ $message->id }}" data-toggle="modal" class="MainNavText"
                       id="message_{{ $message->id }}_link"
                       href="#message_{{ $message->id }}"><i class="si si-magnifier"></i> Read Message</a>
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
    @foreach($messages as $message)

        <!-------------------------------- Modal: TITLE Start------------------------------------------->
        @include('layouts._modal_panel_start',[
            'id' => 'message_'.$message->id,
            'title' => $message->subject
        ])

        <strong>From:</strong> {{ $message->from->fullName }}<br />
        <strong>To:</strong> {{ $message->to->fullName }}<br />
        <strong>Send On:</strong> {{ $message->created_at }}<br />
        <hr />
        <strong>Subject:</strong><br />
        {{ $message->subject }}<br /><br />
        <strong>Message:</strong> <br />
        {!! $message->body  !!} <br />
        <br /><br />
        @include('layouts._modal_panel_end')
        <!-------------------------------- Modal: TITLE END------------------------------------------->
        <!------   data-toggle="modal" data-target="#modal-block-ID". ----->
    @endforeach

    <!-------------------------------- Modal: New Message Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-new-message',
        'title' => 'New Message'
    ])

    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!-----------------------New all_students radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'all_students',
        'label' => 'All Parents',
        'array' => [true => 'Yes', false => 'No'],
        'selected' => false,
        'required' => true
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <div id="student_dropdown">
    <!----------------------------------------------------------------------------->
    <!---------------------------New class_id[] dropdown----------------------------->
    @include('layouts._forms._input_dropdown_multiple',[
        'name' => 'student_id',
        'label' => 'Student\'s Parents',
        'array' => $student_dropdown,
        'class' => null,
        'selected' => null, // []
        'required' => true,
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    </div>

    <!----------------------------------------------------------------------------->
    <!---------------------------New subject text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'subject',
        'label' => 'Subject',
        'placeholder' => '',
        'required' => true,
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
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Message END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-new-message". ----->
@endsection

@section('js_after')

    {!! JsValidator::formRequest('\App\Http\Requests\StoreClassMessageRequest','#admin-form') !!}

    <script type="text/javascript">

        jQuery(document).ready(function () {

            // Init Select2 - Basic Multiple
            $("#student_id").select2({
                placeholder: "Select one or more recipients...",
                allowClear: true,
                width: '100%'
            });

            $('input[name="all_students"]').on('change', function() {
                if (this.value === '1')  {
                    $('#student_dropdown').hide();
                } else {
                    $('#student_dropdown').show();
                }
            });

            @foreach($messages as $message)
            $('#message_{{ $message->id }}_link').click(function (event) {
                event.preventDefault();
                $.ajax({
                    url: '/api/message/{{ $message->uuid }}/read',
                    dataType: 'json',
                    data: '',
                    success: function (data) {
                        // Your Code here
                        if (data === true) {
                            if ($('#message_{{ $message->id }}_icon').hasClass('fa')) {
                                $('#message_{{ $message->id }}_icon')
                                    .removeClass('fa fa-circle')
                                    .addClass('si si-envelope-letter')
                                    .css("color", "");
                            }
                        }
                    }
                })
            });
            @endforeach


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
