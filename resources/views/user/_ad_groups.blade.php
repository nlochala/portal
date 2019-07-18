<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Active Directory Group Memberships', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- TABLE OF GROUPS -->
@if($user->adGroups->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['id' => 'ad_groups_table', 'table_head' => ['Azure ID','Name','Group Email']])
    @foreach($user->adGroups as $group)
        <tr>
            <td>{{ $group->azure_id }}</td>
            <td>{{ $group->name }}</td>
            <td>
            @if ($group->email)
                    <a href="mailto:{{ $group->email }}">{{ $group->email }}</a>
            @else
                --
            @endif
            </td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->