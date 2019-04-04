<!-- START FORM----------------------------------------------------------------------------->
{!! Form::model($visa,['method' => 'PATCH','files' => true, 'id' => "visa-edit-form-$visa->uuid",'url' => "/employee/$employee->uuid/visa/$visa->uuid/update_visa"]) !!}
<!----------------------------------------------------------------------------->
<!---------------------------New is_active dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'is_active_' . $visa->id,
    'label' => 'Is the visa active?',
    'array' => $status_dropdown,
    'class' => null,
    'selected' => $visa->is_active,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New visa_type_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'visa_type_id_' . $visa->id,
    'label' => 'Visa Type',
    'array' => $visa_type_dropdown,
    'class' => null,
    'selected' => $visa->visa_type_id,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New visa_entry_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'visa_entry_id_' . $visa->id,
    'label' => 'Entry Type',
    'array' => $entry_dropdown,
    'class' => null,
    'selected' => $visa->visa_entry_id,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New number text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'number',
    'label' => 'Visa Number',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New entry_duration text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'entry_duration',
    'label' => 'Entry Duration (Not Required for Work Visa)',
    'placeholder' => '',
    'required' => false
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New issue_Date date field----------------------------->
@include('layouts._forms._input_date',[
    'name' => 'issue_date_' . $visa->id,
    'label' => 'Issue Date',
    'format' => 'yyyy-mm-dd',
    'required' => true,
    'selected' => $visa->issue_date->format('Y-m-d')
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New expiration_date date field----------------------------->
@include('layouts._forms._input_date',[
    'name' => 'expiration_date_' . $visa->id,
    'label' => 'Expiration Date',
    'format' => 'yyyy-mm-dd',
    'required' => true,
    'selected' => $visa->expiration_date->format('Y-m-d')
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New image_file_id file field----------------------------->
@include('layouts._forms._input_file_upload', [
    'name' => 'image_file_id',
    'label' => 'Visa Image',
    'required' => false
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->
@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Visa Edit END------------------------------------------->
