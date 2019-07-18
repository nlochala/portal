<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => $employee->person->fullName().' - '.$employee->status->name,'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<span class="badge badge-primary"><i class=""></i> ID: {{ $employee->id }}</span>

@include('_tables.new-table',['class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $employee->person->given_name }} {{ $employee->person->name_in_chinese ?? ''}}</td>
    <td rowspan="7"><div style="float: right">{!! $employee->person->profileImage() !!}</div></td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $employee->person->family_name }} </td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $employee->person->preferred_name }}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $employee->person->nationality->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $employee->person->primaryLanguage->name ?? '--' }}</td>
</tr>
<tr>
    <td>{!! $employee->person->emails() !!}</td>
</tr>
<tr>
    <td>{!! $employee->person->phoneNumbers() ?? '<strong>Phone Number: </strong>--'!!} </td>
</tr>

@include('_tables.end-new-table')

<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/employee/{{ $employee->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Guardian
</button>



@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->