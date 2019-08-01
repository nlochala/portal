@extends('layouts.backend')

@section('content')
    @include('class._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{!! $class->fullName(true)!!} - Edit Enrollment</h1>

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

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 3])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
        @include('layouts._panels_start_panel', ['title' => 'Filter Options', 'with_block' => false])
        {{-- START BLOCK OPTIONS panel.block --}}
        @include('layouts._panels_start_content')

        <ul>
            <li>{!! link_to('/class/'.$class->uuid.'/edit_enrollment/gradeLevels', 'Grade Levels') !!}</li>
            <li>{!! link_to('/class/'.$class->uuid.'/edit_enrollment/homeroom', 'Homerooms') !!}</li>
        </ul>

        @include('layouts._panels_end_content')
        @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Quarter 1 Enrollment', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri().'/'.$quarters[0]->uuid]) !!}
    <select multiple="multiple" id="q1-student-list" name="students[]">
        @foreach($enrollment_lists as $grade => $roster)
            <optgroup label="{{ $grade }}">
                @foreach($roster as $id => $student)
                    @if(in_array($id, $q1Enrollment))
                        <option value="{{ $id }}" selected>{{ $student }}</option>
                    @else
                        <option value="{{ $id }}">{{ $student }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach
    </select>
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Quarter 2 Enrollment', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri().'/'.$quarters[1]->uuid]) !!}
    <select multiple="multiple" id="q2-student-list" name="students[]">
        @foreach($enrollment_lists as $grade => $roster)
            <optgroup label="{{ $grade }}">
                @foreach($roster as $id => $student)
                    @if(in_array($id, $q2Enrollment))
                        <option value="{{ $id }}" selected>{{ $student }}</option>
                    @else
                        <option value="{{ $id }}">{{ $student }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach
    </select>
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Quarter 3 Enrollment', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri().'/'.$quarters[2]->uuid]) !!}
    <select multiple="multiple" id="q3-student-list" name="students[]">
        @foreach($enrollment_lists as $grade => $roster)
            <optgroup label="{{ $grade }}">
                @foreach($roster as $id => $student)
                    @if(in_array($id, $q3Enrollment))
                        <option value="{{ $id }}" selected>{{ $student }}</option>
                    @else
                        <option value="{{ $id }}">{{ $student }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach
    </select>
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Quarter 4 Enrollment', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($class,['method' => 'PATCH','files' => false, 'id' => 'admin-form','url' => request()->getRequestUri().'/'.$quarters[3]->uuid]) !!}
    <select multiple="multiple" id="q4-student-list" name="students[]">
        @foreach($enrollment_lists as $grade => $roster)
            <optgroup label="{{ $grade }}">
                @foreach($roster as $id => $student)
                    @if(in_array($id, $q4Enrollment))
                        <option value="{{ $id }}" selected>{{ $student }}</option>
                    @else
                        <option value="{{ $id }}">{{ $student }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach
    </select>
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
@endsection


@section('js_after')
    @include('class._enrollment_js_q1')
    @include('class._enrollment_js_q2')
    @include('class._enrollment_js_q3')
    @include('class._enrollment_js_q4')
@endsection
