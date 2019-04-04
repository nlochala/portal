<!-- START FORM----------------------------------------------------------------------------->
{!! Form::model($person,['method' => 'PATCH','id' => 'email-form','url' => '/employee/' . $employee->uuid . '/profile/store_email']) !!}
<!----------------------------------------------------------------------------->
<!---------------------------New email_primary text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'email_primary',
    'label' => 'Primary Email Address',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New email_primary text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'email_secondary',
    'label' => 'Secondary Email Address',
    'placeholder' => '',
    'required' => false
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<hr />
<!----------------------------------------------------------------------------->
<!---------------------------New email_school text field----------------------------->
@if(empty($person->email_school))
    @include('layouts._forms._input_text',[
        'name' => 'email_school',
        'label' => 'TLC Email Address',
        'placeholder' => 'xxxx@tlcdg.com',
        'required' => false
      ])
@else
    @include('layouts._forms._input_text_disabled',[
        'name' => 'email_school',
        'label' => 'TLC Email Address',
        'placeholder' => 'xxxx@tlcdg.com',
      ])
@endif
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->
