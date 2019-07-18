<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Overview','with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<h4>
    <span class="badge badge-primary"><i class=""></i> Guardian ID: {{ $guardian->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Person ID: {{ $guardian->person->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Type: {{ $guardian->type->name ?? '--'}}</span>
</h4>

@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $guardian->person->given_name }} {{ $guardian->person->name_in_chinese ?? ''}}</td>
    <td><strong>School Email:</strong> <a href="mailto:{{ $guardian->person->email_school }}">{{ $guardian->person->email_school }}</a></td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $guardian->person->family_name }} </td>
    <td><strong>Primary Email:</strong> <a href="mailto:{{ $guardian->person->email_primary}}">{{ $guardian->person->email_primary}}</a></td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $guardian->person->preferred_name }}</td>
    <td><strong>Guardian Type:</strong> {{ $guardian->type->name}}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $guardian->person->nationality->name ?? '--' }}</td>
    <td rowspan="2">{!! $guardian->person->phoneNumbers() !!}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $guardian->person->primaryLanguage->name ?? '--' }}</td>
</tr>
@include('_tables.end-new-table')

<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/guardian/{{ $guardian->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Guardian
</button>

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->