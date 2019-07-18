<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Position', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- TABLE OF POSITIONS -->
@if($employee->positions->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @php

    @endphp

    @include('_tables.new-table',['id' => 'position-table', 'table_head' => ['ID','Title','Position Type', 'Area of Responsibility', 'Supervisor']])
    @foreach($employee->positions as $position)
        <tr>
            <td>{{ $position->id }}</td>
            <td><a href="/position/{{ $position->uuid }}">{{ $position->name }}</a></td>
            <td>{{ $position->type->name }}</td>
            <td>{{ $position->school->name }}</td>
            <td><a href="/position/{{ $position->supervisor->uuid }}">{{ $position->supervisor->name }}</a></td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->