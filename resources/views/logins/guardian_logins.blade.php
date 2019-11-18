@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Parent Portal Logins',
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
            'page_uri'  => request()->getRequestUri()
        ]
    ]
])
    @include('layouts._content_start')

    @if(env('EXPORT_GUARDIAN_LOGINS') && auth()->user()->can('permissions'))
    <button type="button" class="btn btn-hero-lg btn-hero-primary mr-1 mb-3"
            onclick="window.location.href='/guardian/export_guardian_logins'">
        <i class="fa fa-file-export"></i> Generate New Guardian Logins
    </button>
    @endif
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
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Logins', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- TABLE OF LOGINS -->
    @if($guardians->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        <!-- TABLE OF Guardians -->@include('_tables.new-table',['id' => 'guardian_table', 'table_head' => ['ID', 'Name', 'Type', 'Email', 'Mobile Number','Username','Password']])
        @foreach($guardians as $guardian)
            <tr>
                <td>{{ $guardian->id }}</td>
                <td>{!! $guardian->name!!}</td>
                <td>{{ $guardian->type->name }}</td>
                <td>{!! $guardian->person->emails()!!}</td>
                <td>{!! $guardian->person->phoneNumbers()!!}</td>
                <td>{{ $guardian->username ?? '--' }}</td>
                <td>{{ $guardian->password ?? '--' }}</td>
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

            var tableguardian = $('#guardian_table').DataTable( {
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
