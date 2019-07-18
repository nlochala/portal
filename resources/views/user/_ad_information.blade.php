<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Login Details', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<h4>
    <span class="badge badge-primary"><i class=""></i> User ID: {{ $user->id }}</span>
    <span class="badge badge-primary"><i class=""></i> Username: {{ $user->username }}</span>
</h4>

@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'ad_info_panel_table', 'table_head' => ['']])
<tr>
    <td><strong>Display Name:</strong> {{ $user->display_name }}</td>
</tr>
<tr>
    <td><strong>School Email:</strong> {{ $user->email }}</td>
</tr>
@include('_tables.end-new-table')

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->