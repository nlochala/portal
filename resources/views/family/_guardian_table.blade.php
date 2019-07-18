<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Family Members - Guardians', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- TABLE OF GUARDIANS -->
@if($family->guardians->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['id' => 'guardian_table', 'table_head' => ['ID','Name','Guardian Type']])
    @foreach($family->guardians as $guardian)
        <tr>
            <td>{{ $guardian->id }}</td>
            <td>{!! $guardian->name !!}</td>
            <td>{{ $guardian->type->name }}</td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->