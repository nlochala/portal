<!-------------------------------- Modal: Associated Classes Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-classes',
    'title' => 'Associated Classes'
])

<!-- TABLE OF CLASSES -->
@if($course->classes->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['id' => 'classes-table', 'table_head' => ['ID','Name','Room Assignment','Teachers','Enrolled','Actions']])
    @foreach($course->classes as $class)
        <tr>
            <td>{{ $class->id }}</td>
            <td>{!! $class->fullName(true) !!}</td>
            <td>{{ $class->room->buildingNumber.' - '.$class->room->description }}</td>
            <td>{!! $class->getTeachers() !!}</td>
            <td>{{ $class->$relationship()->count() }} / {{ $course->max_class_size ?? '18' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-info" data-toggle="tooltip" title="View Details"
                        onclick="window.location.href='/class/{{ $class->uuid }}'">
                    <i class="si si-magnifier"></i>
                </button>
            </td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

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
