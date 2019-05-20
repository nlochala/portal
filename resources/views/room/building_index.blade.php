@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Buildings',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Buildings',
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
    @include('layouts._panels_start_panel', ['title' => 'Buildings Management', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Buildings Management -->@include('_tables.new-table',['id' => 'building_table', 'table_head' => ['ID', 'Abbreviation', 'Name']])
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
            var editorbuilding = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/building/ajaxstorebuilding') }}",
                table: "#building_table",
                idSrc: 'id',
                fields: [{
                    label: "Abbreviation:",
                    name: "short_name"
                }, {
                    label: "Name:",
                    name: "name"
                },
                ]
            });

            var tablebuilding = $('#building_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/building/ajaxshowbuilding') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "short_name"},
                    {data: "name"},
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
                    {extend: "create", editor: editorbuilding, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorbuilding, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorbuilding, className: 'btn-sm btn-hero-danger'},

                ]
            });
        });
    </script>
@endsection