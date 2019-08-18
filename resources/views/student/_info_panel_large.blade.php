<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Overview','with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<h4>
    <span class="badge badge-primary"><i class=""></i> Student ID: {{ $student->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Person ID: {{ $student->person->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Age: {{ $student->person->age }}</span>
    <span class="badge badge-primary"><i class=""></i> Gender: {{ $student->person->gender }}</span>
    <span style="float: right" class="badge badge-info"><i class=""></i> {{ $student->status->name ?? '--' }}</span>
</h4>

@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $student->person->given_name }} {{ $student->person->name_in_chinese ?? ''}}</td>
    <td><strong>School Email:</strong> <a href="mailto:{{ $student->person->email_school }}">{{ $student->person->email_school ?? '--' }}</a></td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $student->person->family_name }} </td>
    <td><strong>Primary Email:</strong> <a href="mailto:{{ $student->person->email_primary}}">{{ $student->person->email_primary ?? '--' }}</a></td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $student->person->preferred_name }}</td>
    <td><strong>Student Type:</strong> {{ $student->status->name ?? '--'}}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $student->person->nationality->name ?? '--' }}</td>
    <td><strong>Grade Level:</strong> {{ $student->gradeLevel->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $student->person->primaryLanguage->name ?? '--' }}</td>
    <td><strong>Date of Birth:</strong> {{ $student->person->dob->format('Y-m-d') }} ({{ $student->person->age }})</td>
</tr>
@include('_tables.end-new-table')
@can('student.show.full_profile')
<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/student/{{ $student->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Student
</button>
@endcan

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
