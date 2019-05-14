@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Employee Positions - Index',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Position Index',
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
    <button type="button" class="btn btn-hero-success" data-toggle="tooltip" title="New Position"
            onclick="window.location.href='/position/create'">
        <i class="fa fa-plus"></i> New Position
    </button>
    <hr />
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Positions', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF POSITIONS -->
    @include('_tables.new-table',['class' => 'table-sm','id' => 'positions_table', 'table_head' => ['ID','Name','Type','Area of Responsibility','Supervising Position','Stipend','Actions']])
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
            var tableposition = $('#positions_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 30,
                ajax: {"url": "/api/position/ajaxshowposition", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "type.name"},
                    {data: "school.name"},
                    {
                        data: "supervisor",
                        render: function (data, type, row) {
                            // IF EXPECTING A STRING
                            if (data == null) {
                                return '';
                            }

                            return data.name;
                        }
                    },
                    {
                        data: "stipend",
                        render: function (data, type, row) {
                            if (data == null || data == '') {
                                return 0 + ' ¥';
                            }

                            return data + ' ¥';
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "        <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/position/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/position/" + data + "/edit'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-archive-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-toggle=\"tooltip\" title=\"Archive\"\n" +
                                "                    onclick=\"window.location.href='/position/" + data + "/archive'\">\n" +
                                "                <i class=\"fa fa-times\"></i>\n" +
                                "            </button>\n" +
                                "        </div>"
                        }
                    }
                ]
            });
            new $.fn.dataTable.Buttons(tableposition, {
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LETTER'
                    },
                    'print'
                ]
            });

            tableposition.buttons(2, null).container().appendTo(
                tableposition.table().container()
            );
        });
    </script>
@endsection