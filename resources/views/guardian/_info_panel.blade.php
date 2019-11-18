<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => $guardian->person->fullName().' - '.$guardian->type->name,'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<h4>
    <span class="badge badge-primary"><i class=""></i> ID: {{ $guardian->id }}</span>
</h4>

@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'info_panel_table', 'table_head' => ['','']])
<tr>
    <td><strong>Given Name:</strong> {{ $guardian->person->given_name }} {{ $guardian->person->name_in_chinese ?? ''}}
    </td>
    <td rowspan="7">
        <div style="float: right">{!! $guardian->person->profileImage() !!}</div>
    </td>
</tr>
<tr>
    <td><strong>Family Name:</strong> {{ $guardian->person->family_name }} </td>
</tr>
<tr>
    <td><strong>Preferred Name:</strong> {{ $guardian->person->preferred_name }}</td>
</tr>
<tr>
    <td><strong>Nationality:</strong> {{ $guardian->person->nationality->name ?? '--' }}</td>
</tr>
<tr>
    <td><strong>Primary Language:</strong> {{ $guardian->person->primaryLanguage->name ?? '--' }}</td>
</tr>
<tr>
    <td>{!! $guardian->person->emails() !!}</td>
</tr>
<tr>
    <td>{!! $guardian->person->phoneNumbers() ?? '<strong>Phone Number: </strong>--'!!} </td>
</tr>

@include('_tables.end-new-table')

@cannot('guardian-only')
<button type="button" class="btn btn-outline-danger mr-1 mb-3"
        onclick="window.location.href='/guardian/{{ $guardian->uuid }}/profile'">
    <i class="fa fa-pen"></i> Edit Guardian
</button>
@endcannot


@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
