@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'School Years',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'School Year',
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
    <h1 class="font-w400">The current school year is: {{ App\Year::currentYear()->name }}</h1>
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'School Year', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF YEARS -->
    @include('_tables.new-table',['id' => 'year_table', 'table_head' => ['ID', 'Year Start', 'Year End', 'Start Date', 'End Date']])
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
            var editoryear = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/year/ajaxstoreyear') }}",
                table: "#year_table",
                idSrc: 'id',
                fields: [{
                    label: "Year Start:",
                    name: "year_start"
                }, {
                    label: "Year End:",
                    name: "year_end"
                }, {
                    label: "Start Date:",
                    name: "start_date",
                    type: "datetime",
                    opts: {
                        showOn: 'focus',
                        format: 'YYYY-MM-DD'
                    }
                }, {
                    label: "End Date:",
                    name: "end_date",
                    type: "datetime",
                    opts: {
                        showOn: 'focus',
                        format: 'YYYY-MM-DD'
                    }
                },
                ]
            });

            var tableyear = $('#year_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/year/ajaxshowyear') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "year_start"},
                    {data: "year_end"},
                    {data: "start_date"},
                    {data: "end_date"}
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
                        className: 'btn-sm btn-hero-primary',
                        autoClose: true
                    },
                    {
                        text: '',
                        className: 'btn-sm btn-light',
                        action: function ( e, dt, node, config ) {
                            this.disable();
                        }
                    },
                    {extend: "create", editor: editoryear, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editoryear, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editoryear, className: 'btn-sm btn-hero-danger'},
                ]
            });
        });
    </script>
@endsection