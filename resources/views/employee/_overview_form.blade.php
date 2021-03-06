@if(isset($employee))
    <!----------------------------------------------------------------------------->
    <!---------------------------New start_date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'start_date',
        'label' => 'Start Date',
        'format' => 'yyyy-mm-dd',
        'required' => true,
        'selected' => $employee->start_date
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New end_date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'end_date',
        'label' => 'End Date',
        'format' => 'yyyy-mm-dd',
        'required' => false,
        'selected' => $employee->end_date
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New employee_classification_id radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'employee_classification_id',
        'label' => 'Classification',
        'array' => $classifications,
        'required' => true,
        'selected' => $employee->employee_classification_id
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New employee_status_id radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'employee_status_id',
        'label' => 'Status',
        'array' => $statuses,
        'required' => true,
        'selected' => $employee->employee_status_id
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
@else
    <!----------------------------------------------------------------------------->
    <!---------------------------New start_date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'start_date',
        'label' => 'Start Date',
        'format' => 'yyyy-mm-dd',
        'required' => true,
        'selected' => null,
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New end_date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'end_date',
        'label' => 'End Date',
        'format' => 'yyyy-mm-dd',
        'required' => false,
        'selected' => null,
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New employee_classification_id radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'employee_classification_id',
        'label' => 'Classification',
        'array' => $classifications,
        'required' => true,
        'selected' => null,
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New employee_status_id radio------------------------------------->
    @include('layouts._forms._input_radio',[
        'name' => 'employee_status_id',
        'label' => 'Status',
        'array' => $statuses,
        'required' => true,
        'selected' => null,
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
@endif