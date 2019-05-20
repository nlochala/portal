@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Room Types',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Room Types',
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
    @include('layouts._panels_start_panel', ['title' => 'Room Types Management', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Room Types Management -->@include('_tables.new-table',['id' => 'room_type_table', 'table_head' => ['ID', 'Name', 'Description']])
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
            var editorroom_type = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/room_type/ajaxstoreroom_type') }}",
                table: "#room_type_table",
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

            var tableroom_type = $('#room_type_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/room_type/ajaxshowroom_type') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "description"},
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
                        action: function ( e, dt, node, config ) {
                            this.disable();
                        }
                    },
                    {extend: "create", editor: editorroom_type, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorroom_type, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorroom_type, className: 'btn-sm btn-hero-danger'},

                ]
            });
        });
    </script>
@endsection