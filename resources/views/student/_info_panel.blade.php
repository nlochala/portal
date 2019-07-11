<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => $student->person->fullName().' - '.$student->gradeLevel->name,'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<span class="badge badge-primary"><i class=""></i> ID: {{ $student->id }}</span>
<span class="badge badge-primary"><i class=""></i> Age: {{ $student->person->age }}</span>
<span class="badge badge-primary"><i class=""></i> Gender: {{ $student->person->gender }}</span>
<span style="float: right" class="badge badge-info"><i class=""></i> {{ $student->status->name }}</span>

@include('_tables.new-table',['class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $student->person->given_name }} {{ $student->person->name_in_chinese ?? ''}}</td>
    <td rowspan="8"><div style="float: right">{!! $student->person->profileImage() !!}</div></td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $student->person->family_name }} </td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $student->person->preferred_name }}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $student->person->nationality->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $student->person->primaryLanguage->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Date of Birth:</strong> {{ $student->person->dob->format('Y-m-d') }} ({{ $student->person->age }})</td>
</tr>
<tr>
    <td><strong>Start Date:</strong> {{ $student->start_date }}</td>
</tr>
<tr>
    <td><strong>End Date:</strong> {{ $student->end_date ?? '--'}}</td>
</tr>

@include('_tables.end-new-table')

<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/student/{{ $student->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Student
</button>
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->