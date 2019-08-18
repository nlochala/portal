<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Overview','with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<h4>
    <span class="badge badge-primary"><i class=""></i> Employee ID: {{ $employee->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Person ID: {{ $employee->person->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Status: {{ $employee->status->name ?? '--'}}</span>
    <span class="badge badge-primary"><i class=""></i> Classification: {{ $employee->classification->name ?? '--'}}</span>
</h4>

@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $employee->person->given_name }} {{ $employee->person->name_in_chinese ?? ''}}</td>
    <td><strong>School Email:</strong> <a href="mailto:{{ $employee->person->email_school }}">{{ $employee->person->email_school }}</a></td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $employee->person->family_name }} </td>
    <td><strong>Employee Status:</strong> {{ $employee->status->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $employee->person->preferred_name }}</td>
    <td><strong>Employee Classification:</strong> {{ $employee->classification->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $employee->person->nationality->name ?? '--' }}</td>
    <td><strong>Start Date:</strong> {{ $employee->start_date ?? '--'}}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $employee->person->primaryLanguage->name ?? '--' }}</td>
    <td><strong>End Date:</strong> {{ $employee->end_date ?? '--'}}</td>
</tr>
@include('_tables.end-new-table')

@can('employees.show.full_profile')
<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/employee/{{ $employee->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Employee
</button>
@endcan

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
