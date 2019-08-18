@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Portal Permissions',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Portal Permissions',
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
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Permissions', 'with_block' => false])
    @include('layouts._panels_start_content')

    <!-- TABLE OF YEARS -->
    @include('_tables.new-table',['id' => 'permission_table', 'table_head' => ['ID', 'Name', 'Description', 'Role Count']])
    @include('_tables.end-new-table')

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
@endsection

@section('js_after')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var editorpermission = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/permission/ajaxstorepermission') }}",
                table: "#permission_table",
                idSrc: 'id',
                fields: [{
                    label: "Name:",
                    name: "name"
                }, {
                    label: "Description:",
                    name: "description"
                },
                ]
            });

            var tablepermission = $('#permission_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/permission/ajaxshowpermission') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "description"},
                    {
                        data: "roles",
                        render: function (data, type, row) {
                            return data.length;
                        }
                    },
                ],
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
                    {
                        text: '',
                        className: 'btn-sm btn-light',
                        action: function (e, dt, node, config) {
                            this.disable();
                        }
                    },
                    {extend: "create", editor: editorpermission, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorpermission, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorpermission, className: 'btn-sm btn-hero-danger'},

                ]
            });

        });
    </script>
@endsection
