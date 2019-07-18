<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Family Members - Students', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- TABLE OF GUARDIANS -->
@if($family->students->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['id' => 'student_table', 'table_head' => ['ID','Name','Student Status', 'Grade Level']])
    @foreach($family->students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{!! $student->name !!}</td>
            <td>{{ $student->status->name }}</td>
            <td>{{ $student->gradeLevel->name }}</td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->