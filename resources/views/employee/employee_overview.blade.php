@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('person._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $employee->person->preferredName() }}'s Employment Overview</h1>
    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel
    panel.row

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Employment Details', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'overview-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New start_date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'start_date',
        'label' => 'Start Date',
        'format' => 'yyyy-mm-dd',
        'required' => false,
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
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Employee Assignments', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF POSITIONS -->
    @if($employee->positions->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'assigned-positions-table', 'table_head' => ['Title','Position Type','Area of Responsibility', 'Included Stipend', 'Action']])
        @foreach($employee->positions as $position)
            <tr>
                <td>{{ $position->name }}</td>
                <td>{{ $position->type->name }}</td>
                <td>{{ $position->school->name }}</td>
                <td>{{ $position->stipend }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="View Details"
                                onclick="window.location.href='/employee/{{ $employee->uuid }}/position/view_details#{{ $position->uuid }}'">
                            <i class="si si-magnifier"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Remove Position"
                                onclick="window.location.href='/employee/{{ $employee->uuid }}/position/{{ $position->uuid }}/remove'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif

    <hr />

    <button type="button" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-positions">
        <i class="fa fa-plus"></i> Add Additional Position
    </button>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')

    <!-------------------------------- Modal: Potential Assignments Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-positions',
        'title' => 'Potential Assignments'
    ])

    @include('employee.position_table')
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Potential Assignments END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-positions". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->
    {!! JsValidator::formRequest('\App\Http\Requests\StoreEmployeeOverviewRequest','#overview-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#start_date").datepicker();
            $("#end_date").datepicker();

            @include('employee.position_table_js')
        });
    </script>
@endsection