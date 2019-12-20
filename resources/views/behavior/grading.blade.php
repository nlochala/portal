@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $quarter->name }} - Student Behavior</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Assessments', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF STUDENTS -->
    @if($students->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'student-table', 'table_head' => $table_head])
        @foreach($students as $student)
            <tr>
                <td>{!! $student->name !!}</td>
                @foreach($standards as $standard)
                    @if($student->behaviorAssessments->where('behavior_standard_id', $standard->id)->isEmpty())
                        <td>--</td>
                    @else
                        <td>{{ $student->behaviorAssessments->where('behavior_standard_id', $standard->id)->first()->item->name }}</td>
                    @endif
                @endforeach
                @if($student->behaviorAssessmentAverages->isEmpty())
                    <td>--</td>
                @else
                    @if ($student->behaviorAssessmentAverages->first()->grade !== 'Satisfactory')
                        <td bgcolor="#FFE5EE">{{ $student->behaviorAssessmentAverages->first()->grade }}</td>
                    @else
                        <td>{{ $student->behaviorAssessmentAverages->first()->grade }}</td>
                    @endif
                @endif
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                            title="Edit" data-target="#modal-block-{{ $student->id }}">
                        <i class="fa fa-pen"></i>
                    </button>
                <td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')

    @foreach($students as $student)
        <!-------------------------------- Modal: Student Behavior Start------------------------------------------->
        @include('layouts._modal_panel_start',[
            'id' => 'modal-block-'.$student->id,
            'title' => $student->person->fullName()
        ])
        <!-- START FORM----------------------------------------------------------------------------->

        {!! Form::open(['files' => false, 'id' => 'admin-form-'.$student->id,'url' => request()->getRequestUri()]) !!}
        @foreach($standards as $standard)
            @if($student->behaviorAssessments->where('behavior_standard_id', $standard->id)->isEmpty())
                <!----------------------------------------------------------------------------->
                <!---------------------------New behavior_standard_id dropdown----------------------------->
                @include('layouts._forms._input_dropdown',[
                    'name' => 'behavior_standard_id-'.$standard->id,
                    'label' => $standard->name,
                    'array' => $dropdown_arrays[$standard->id],
                    'class' => null,
                    'selected' => null,
                    'required' => true
                  ])
                <!----------------------------------------------------------------------------->
                <!----------------------------------------------------------------------------->
            @else
                <!----------------------------------------------------------------------------->
                <!---------------------------New behavior_standard_id dropdown----------------------------->
                @include('layouts._forms._input_dropdown',[
                    'name' => 'behavior_standard_id-'.$standard->id,
                    'label' => $standard->name,
                    'array' => $dropdown_arrays[$standard->id],
                    'class' => null,
                    'selected' => $student->behaviorAssessments->where('behavior_standard_id', $standard->id)->first()->item->id,
                    'required' => true
                  ])
                <!----------------------------------------------------------------------------->
                <!----------------------------------------------------------------------------->
            @endif
        @endforeach
        {{-- HIDDEN INPUT NAME=student_id VALUE=$student->id ID=student_id  --}}
        {!! Form::hidden('student_id', $student->id,['id' => 'student_id']) !!}
        @include('layouts._forms._form_close')
        <!-- END FORM----------------------------------------------------------------------------->
        @include('layouts._modal_panel_end')
        <!-------------------------------- Modal: Student Behavior END------------------------------------------->
        <!------   data-toggle="modal" data-target="#modal-block-id". ----->
    @endforeach
@endsection

@section('js_after')

    @foreach($students as $student)
    {!! JsValidator::formRequest('\App\Http\Requests\StoreBehaviorAssessmentRequest','#admin-form-'.$student->id) !!}
    @endforeach
    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {


        });
    </script>
@endsection
