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
    <strong>Message:</strong><br />
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

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: New Message END------------------------------------------->
<!------   data-toggle="modal" data-target="#modal-block-new-message". ----->
