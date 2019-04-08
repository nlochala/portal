@include('layouts._forms._row_start', ['size' => 12])
<!----------------------------------------------------------------------------->
<!---------------------------New is_active dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'is_active',
    'label' => 'What is the status of this ID Card?',
    'array' => $status_dropdown,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New name text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'name',
    'label' => 'Name (In Chinese Characters)',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New number text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'number',
    'label' => 'Card Number',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New issue_date date field----------------------------->
@include('layouts._forms._input_date',[
    'name' => 'issue_date',
    'label' => 'Issue Date',
    'format' => 'yyyy-mm-dd',
    'required' => true,
    'selected' => null
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New expiration_date date field----------------------------->
@include('layouts._forms._input_date',[
    'name' => 'expiration_date',
    'label' => 'Expiration Date',
    'format' => 'yyyy-mm-dd',
    'required' => true,
    'selected' => null
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New front_image_file_id file field----------------------------->
@include('layouts._forms._input_file_upload', [
    'name' => 'front_image_file_id',
    'label' => 'Card Image (Front)',
    'required' => false
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New back_image_file_id file field----------------------------->
@include('layouts._forms._input_file_upload', [
    'name' => 'back_image_file_id',
    'label' => 'Card Image (Back)',
    'required' => false
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._row_end')
