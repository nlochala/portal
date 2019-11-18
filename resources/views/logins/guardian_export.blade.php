@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'New Parent Portal Logins - Export',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Guardians Index',
            'page_uri'  => '/guardian/index'
        ],
        [
            'page_name' => 'Parent Portal Logins',
            'page_uri'  => '/guardian/logins',
        ],
        [
            'page_name' => 'Parent Portal Login - Exports',
            'page_uri'  => request()->getRequestUri()
        ]
    ]
])
    @include('layouts._content_start')
    <!--
    panel.row
    panel.column
    panel.panel
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel
    panel.row

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @if(env('EXPORT_GUARDIAN_LOGINS') && auth()->user()->can('permissions') && ! $guardians->isEmpty())
        <button type="button" class="btn btn-hero-lg btn-hero-success mr-1 mb-3"
                onclick="window.location.href='/guardian/export_guardian_logins/imported'">
            <i class="fa fa-check-circle"></i> Mark All Guardians As Imported
        </button>
    @endif
    <u><h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">Office 365</h1></u>
    <ul>
        <li>Login to Office 365</li>
        <li>Access the admin panel</li>
        <li>Go to Users -> Active Users</li>
        <li>Click on "Add multiple users" option above the table of users</li>
        <li>Export the below-table as a csv file</li>
        <li>Import file into Office 365 and click verify</li>
        <li>DO NOT assign licenses to the guardian.</li>
        <li>Click finish and it will create the guardian accounts</li>
        <li>Lastly, you need to go to the all-guardians@tlcdg.com group</li>
        <li>Add the newly created guardians to that group</li>
    </ul>

    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'OFFICE 365 - Batch Import', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- TABLE OF LOGINS -->
    @if($guardians->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'o365_table','class' => 'display nowrap', 'style' => 'width:10%', 'table_head' => ['User Name','First Name','Last Name','Display Name','Job Title','Department','Office Number','Office Phone','Mobile Phone','Fax','Address','City','State or Province','ZIP or Postal Code','Country or Region']])
        @foreach($guardians as $guardian)
            <tr>
                <td>{{ $guardian->username }}</td>
                <td>{{ $guardian->person->given_name }} @if($guardian->person->preferred_name !== $guardian->person->given_name)({{ $guardian->person->preferred_name }})@endif</td>
                <td>{{ $guardian->person->family_name }}</td>
                <td>{{ $guardian->person->family_name }}, {{ $guardian->person->given_name }} @if($guardian->person->preferred_name !== $guardian->person->given_name)({{ $guardian->person->preferred_name }})@endif</td>
                <td></td>
                <td>guardian</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    <u><h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">Active Directory</h1></u>
    <ul>
        <li>Remote into the Active Directory server.</li>
        <li>Login using the tsupport account</li>
        <li>Export the guardians in the below-table as a csv file</li>
        <li>Paste them into the Documents/AD Import.csv file</li>
        <li>Click on "Run ISE as Administrator"</li>
        <li>Open the file Documents/ADImportFromO365.ps1</li>
        <li>Run the script</li>
    </ul>
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'ACTIVE DIRECTORY - Batch Import', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- TABLE OF LOGINS -->
    @if($guardians->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'ad_table', 'table_head' => ['firstname','displayname','lastname','email','username','password','ou','department']])
        @foreach($guardians as $guardian)
            <tr>
                <td>{{ $guardian->person->given_name }} @if($guardian->person->preferred_name !== $guardian->person->given_name)({{ $guardian->person->preferred_name }})@endif</td>
                <td>{{ $guardian->person->family_name }}, {{ $guardian->person->given_name }} @if($guardian->person->preferred_name !== $guardian->person->given_name)({{ $guardian->person->preferred_name }})@endif</td>
                <td>{{ $guardian->person->family_name }}</td>
                <td>{{ $guardian->username }}</td>
                <td>{{ preg_replace('/@tlcdg.com/','',$guardian->username) }}</td>
                <td>{{ $guardian->password }}</td>
                <td>{{ env('GUARDIAN_OU') }}</td>
                <td>guardian</td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

            var tableguardian = $('#o365_table').DataTable( {
                dom: "Bfrtip",
                pageLength: 50,
                select: true,
                paging: true,
                scrollX: true,
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fa fa-fw fa-download mr-1"></i>',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            {
                                extend: 'pdf',
                                orientation: 'landscape',
                                pageSize: 'LETTER'
                            },
                            'print',
                        ],
                        fade: true,
                        className: 'btn-sm btn-hero-primary'
                    },
                ]
            });

            var tableguardian1 = $('#ad_table').DataTable( {
                dom: "Bfrtip",
                pageLength: 50,
                select: true,
                paging: true,
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fa fa-fw fa-download mr-1"></i>',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            {
                                extend: 'pdf',
                                orientation: 'landscape',
                                pageSize: 'LETTER'
                            },
                            'print',
                        ],
                        fade: true,
                        className: 'btn-sm btn-hero-primary'
                    },
                ]
            });

        });
    </script>
@endsection
