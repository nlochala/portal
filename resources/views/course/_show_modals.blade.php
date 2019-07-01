<!-------------------------------- Modal: Associated Classes Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-classes',
    'title' => 'Associated Classes'
])

<!-- TABLE OF CLASSES -->@include('_tables.new-table',['id' => 'classes_table', 'table_head' => ['ID', 'Name', 'Age Level', 'Enrolled', 'Teacher', 'Actions']])
@include('_tables.end-new-table')

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Prerequisites Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-prerequisites',
    'title' => 'Current Prerequisites'
])

<!-- TABLE OF  -->@include('_tables.new-table',['id' => 'prerequisite_table','style' => 'width: 100%', 'table_head' => ['ID', 'Abbreviation', 'Name', 'Type', 'Department']])
@include('_tables.end-new-table')

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Prerequisites END------------------------------------------->
<!-------------------------------- Modal: Corequisites Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-corequisites',
    'title' => 'Current Corequisites'
])

<!-- TABLE OF  -->@include('_tables.new-table',['id' => 'corequisite_table','style' => 'width: 100%', 'table_head' => ['ID', 'Abbreviation', 'Name', 'Type', 'Department']])
@include('_tables.end-new-table')

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Corequisites END------------------------------------------->
<!-------------------------------- Modal: Equivalents Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-equivalents',
    'title' => 'Current Equivalents'
])

<!-- TABLE OF  -->@include('_tables.new-table',['id' => 'equivalent_table','style' => 'width: 100%', 'table_head' => ['ID', 'Abbreviation', 'Name', 'Type', 'Department']])
@include('_tables.end-new-table')

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Equivalents END------------------------------------------->
<!------   data-toggle="modal" data-target="#modal-block-prerequisites". ----->
<!-------------------------------- Modal: Course Materials Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-materials',
    'title' => 'Course Materials'
])

<!-- START FORM----------------------------------------------------------------------------->
{!! Form::model($course,['method' => 'PATCH','files' => false, 'id' => 'materials-form','url' => request()->getRequestUri().'/required_materials']) !!}
<!----------------------------------------------------------------------------->
<!------------------------New materials textarea field---------------------------->
@include('layouts._forms._input_text_sm',[
    'name' => 'materials-edit',
    'label' => 'Required Materials',
    'placeholder' => '',
    'required' => true
  ])

{!! Form::hidden('materials', null,['id' => 'materials']) !!}
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->
@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Course Materials END------------------------------------------->
<!------   data-toggle="modal" data-target="#modal-block-materials". ----->
<!-------------------------------- Modal: Edit Course Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-edit',
    'title' => 'Edit Course'
])

<!-- START FORM----------------------------------------------------------------------------->
{!! Form::model($course,['method' => 'PATCH','files' => false, 'id' => 'edit-form','url' => request()->getRequestUri()]) !!}
@include('course._course_form', ['type' => 'update'])

@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Edit Course END------------------------------------------->
<!------   data-toggle="modal" data-target="#modal-block-edit". ----->
