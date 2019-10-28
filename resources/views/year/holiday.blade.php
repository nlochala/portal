@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Holidays',
    'subtitle' => $year->name.' - <small><em><a data-toggle="modal" data-target="#modal-block-date" href="#modal-block-date">Change Year</a></em></small>',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Holidays',
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
    @include('layouts._panels_start_panel', ['title' => 'Holidays', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    @include('_tables.new-table',['id' => 'holiday_table', 'table_head' => ['ID','Name','Start Date','End Date', 'Quarter']])
    @include('_tables.end-new-table')

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
    <!-------------------------------- Modal: Select Year Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-date',
        'title' => 'Select Year'
    ])

    <ul>
        @foreach($years as $year)
            <li><a href="/holiday/{{ $year->uuid }}/index">{{ $year->name }}</a></li>
        @endforeach
    </ul>

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Select Year END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-date". ----->
@endsection

@section('js_after')
    <script type="text/javascript">
        jQuery(document).ready(function () {

            var editorholiday = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/holiday/ajaxstoreholiday') }}",
                table: "#holiday_table",
                idSrc: 'id',
                fields: [
                    {
                        label: "Name:",
                        name: "name"
                    }, {
                        label: "Start Date:",
                        name: "start_date",
                        type: "datetime",
                        opts: {
                            showOn: 'focus',
                            format: 'YYYY-MM-DD'
                        }
                    }, {
                        type: 'hidden',
                        name: 'year',
                        default: '{{ $year->id }}'
                    }, {
                        label: "End Date:",
                        name: "end_date",
                        type: "datetime",
                        opts: {
                            showOn: 'focus',
                            format: 'YYYY-MM-DD'
                        }
                    }, {
                        label: "Is this a staff workday?",
                        name: 'is_staff_workday',
                        type: 'radio',
                        def: false,
                        options: [
                            {label: "Yes", value: true},
                            {label: "No", value: false}
                        ]
                    }
                ]
            });

            var tableholiday = $('#holiday_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/holiday/ajaxshowholiday') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "start_date"},
                    {data: "end_date"},
                    {
                        data: "quarter",
                        render: function (data, type, row) {
                            // IF EXPECTING AN ARRAY OR COLLECTION OF ITEMS
                            if (data === '' || data === null) {
                                return '--';
                            }
                            return data.name;
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
                    {extend: "create", editor: editorholiday, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorholiday, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorholiday, className: 'btn-sm btn-hero-danger'},

                ]
            });

        })
        ;
    </script>
@endsection
