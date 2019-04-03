@include('layouts._forms._heading',['title' => 'New Person Type'])
@include('layouts._forms._row_start', ['size' => 12])
<!----------------------------------------------------------------------------->
<!-----------------------New type_id radio------------------------------------->
@include('layouts._forms._input_radio_inline',[
    'name' => 'type',
    'label' => 'Select the Type of Person to Create',
    'array' => $type_dropdown,
    'required' => true,
    'selected' => null
])

<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._heading',['title' => 'Biographical Information'])
@include('layouts._forms._row_start', ['size' => 12])

@include('person._create_form_biographical')

@include('layouts._forms._row_end')

@include('layouts._forms._heading',['title' => 'Contact Information'])
@include('layouts._forms._row_start', ['size' => 12])
<!----------------------------------------------------------------------------->
<!---------------------------New email_primary text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'email_primary',
    'label' => 'Email - Primary',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New email_secondary text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'email_secondary',
    'label' => 'Email - Secondary',
    'placeholder' => '',
    'required' => false
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._row_end')
@include('layouts._forms._heading',['title' => 'Demographic Information'])
@include('layouts._forms._row_start', ['size' => 12])
@include('person._create_form_demographic')
@include('layouts._forms._row_end')