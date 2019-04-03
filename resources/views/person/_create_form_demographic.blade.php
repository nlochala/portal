<!----------------------------------------------------------------------------->
<!---------------------------New country_of_birth_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'country_of_birth_id',
    'label' => 'Nationality',
    'array' => $country_dropdown,
    'required' => true,
    'class' => null,
    'selected' => null
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New language_primary_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'language_primary_id',
    'label' => 'Language - Primary',
    'array' => $language_dropdown,
    'required' => true,
    'class' => null,
    'selected' => null
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New language_secondary_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'language_secondary_id',
    'label' => 'Language - Secondary',
    'array' => $language_dropdown,
    'required' => false,
    'class' => null,
    'selected' => null
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New language_tertiary_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'language_tertiary_id',
    'label' => 'Language - Tertiary',
    'array' => $language_dropdown,
    'required' => false,
    'class' => null,
    'selected' => null
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New ethnicity_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'ethnicity_id',
    'label' => 'Ethnicity',
    'array' => $ethnicity_dropdown,
    'required' => true,
    'class' => null,
    'selected' => null
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
