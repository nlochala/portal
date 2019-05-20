@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Rooms',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Rooms',
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
    @include('layouts._panels_start_panel', ['title' => 'Room Management', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Room Management -->@include('_tables.new-table',['id' => 'room_table', 'table_head' => ['ID', 'Building', 'Room Type', 'Number', 'Description', 'Phone Extension']])
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
            var editorroom = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/room/ajaxstoreroom') }}",
                table: "#room_table",
                idSrc: 'id',
                fields: [
                    {
                        label: "Building",
                        name: "building_id",
                        type: "select2",
                        opts: {
                            placeholder: "Choose One..."
                        },
                        options: [
                                @foreach($buildings as $building)
                            {
                                label: "{{ $building->name }}", value: "{{ $building->id }}"
                            },
                            @endforeach
                        ]
                    }, {
                        label: "Room Type",
                        name: "room_type_id",
                        type: "select2",
                        opts: {
                            placeholder: "Choose One..."
                        },
                        options: [
                                @foreach($room_types as $room_type)
                            {
                                label: "{{ $room_type->name }}", value: "{{ $room_type->id }}"
                            },
                            @endforeach
                        ]
                    }, {
                        label: "Room Number:",
                        name: "number"
                    }, {
                        label: "Description:",
                        name: "description"
                    }, {
                        label: "Phone Extension:",
                        name: "phone_extension"
                    },
                ]
            });

            var tableroom = $('#room_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/room/ajaxshowroom') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "building.name"},
                    {data: "type.name"},
                    {data: "number"},
                    {data: "description"},
                    {data: "phone_extension"},
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
                    {extend: "create", editor: editorroom, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorroom, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorroom, className: 'btn-sm btn-hero-danger'},

                ]
            });
        });
    </script>
@endsection