@extends('layouts.backend')

@section('content')
    @include('employee._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $employee->person->preferredName() }}'s Position Details</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Table of Contents', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    @if($employee->positions->isEmpty())
        <small><em>This employee does not have any positions assigned to them, yet.</em></small>
    @else
        <ul>
            @foreach($employee->positions as $position)
                <li><a href="#{{ $position->uuid }}">{{ $position->name }}</a></li>
            @endforeach
        </ul>
    @endif

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @foreach($employee->positions as $position)
        @include('layouts._panels_start_column', ['size' => 12, 'id' => $position->uuid])
        <!-------------------------------------------------------------------------------->
        <!----------------------------------New Panel ------------------------------------>
        @include('layouts._panels_start_panel', ['title' => "$position->name", 'with_block' => false])
        {{-- START BLOCK OPTIONS panel.block --}}
        @include('layouts._panels_start_content')

        @include('_tables.new-table',['class' => 'table-borderless', 'id' => $position->id.'_table', 'table_head' => ['','']])
        <tr>
            <td><strong>Position Title:</strong></td>
            <td>{{ $position->name}}</td>
        </tr>
        <tr>
            <td><strong>Type:</strong></td>
            <td>{{ $position->type->name}}</td>
        </tr>
        <tr>
            <td><strong>Area of Responsibility:</strong></td>
            <td>{{ $position->school->name}}</td>
        </tr>
        <tr>
            <td><strong>Supervising Position:</strong></td>
            <td>{{ $position->supervisor->name}}</td>
        </tr>
        <tr>
            <td><strong>Stipend:</strong></td>
            <td>{{ $position->formattedStipend }}</td>
        </tr>
        @include('_tables.end-new-table')
        <strong>Position Description</strong>
        <p>{!! $position->description !!}</p>
        @include('layouts._panels_end_content')
        @include('layouts._panels_end_panel')
        <!-------------------------------------------------------------------------------->
        <!-------------------------------------------------------------------------------->
        @include('layouts._panels_end_column')
    @endforeach
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {


        });
    </script>
@endsection