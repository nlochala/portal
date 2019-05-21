@include('layouts._panels_start_row',['has_uniform_length' => true])
@include('layouts._panels_start_column', ['size' => 12])
<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Grade Scale Details', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- START FORM----------------------------------------------------------------------------->

{!! Form::model($grade_scale,['method' => 'PATCH','files' => false, 'id' => 'grade-scale-form','url' => request()->getRequestUri()]) !!}
<!----------------------------------------------------------------------------->
<!---------------------------New name text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'name',
    'label' => 'Name',
    'placeholder' => 'Grade Scale Name',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New description text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'description',
    'label' => 'Description',
    'placeholder' => 'Grade Scale Description',
    'required' => true
  ])
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
