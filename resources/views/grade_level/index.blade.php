@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Grade Levels',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Grade Levels',
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
    @include('layouts._panels_start_panel', ['title' => 'Grade Level Management', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Grade Levels -->@include('_tables.new-table',['id' => 'grade_level_table', 'table_head' => ['Abbreviation', 'Name', 'Associated School', 'School Year']])
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
            var editorgrade_level = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/grade_level/ajaxstoregrade_level') }}",
                table: "#grade_level_table",
                idSrc: 'id',
                fields: [{
                    label: "Abbreviation:",
                    name: "short_name"
                }, {
                    label: "Name:",
                    name: "name"
                }, {
                    label: "Associated School:",
                    name: "school_id",
                    type: "select2",
                    opts: {
                        placeholder: "Choose One..."
                    },
                    options: [
                            @foreach($schools as $school)
                        {
                            label: "{{ $school->name }}", value: "{{ $school->id }}"
                        },
                        @endforeach
                    ]
                }, {
                    label: "School Year:",
                    name: "year_id",
                    type: "select2",
                    opts: {
                        placeholder: "Choose One..."
                    },
                    options: [
                        @foreach($years as $year)
                        {
                            label: "{{ $year->name }}", value: "{{ $year->id }}"
                        },
                        @endforeach
                    ]
                }
                ]
            });

            var tablegrade_level = $('#grade_level_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/grade_level/ajaxshowgrade_level') }}", "dataSrc": ""},
                columns: [
                    {data: "short_name"},
                    {data: "name"},
                    {data: "school.name"},
                    {
                        data: "year",
                        render: function (data, type, row) {
                            return data.year_start + '-' + data.year_end;
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
                        extend: 'collection',
                        text: '<i class="fa fa-filter"></i>',
                        className: 'btn-sm btn-hero-primary',
                        fade: true,
                        autoClose: true,
                        buttons: [
                                @foreach($years as $year)
                            {
                                text: '{{ $year->name }}',
                                action: function (e, dt, node, config) {
                                    dt.search('{{ $year->name }}').draw();
                                }
                            },
                                @endforeach
                            {
                                text: 'Clear Filters',
                                action: function (e, dt, node, config) {
                                    dt.search('').draw();
                                }
                            },
                        ]
                    },
                    {
                        text: '',
                        className: 'btn-sm btn-light',
                        action: function (e, dt, node, config) {
                            this.disable();
                        }
                    },
                    {extend: "create", editor: editorgrade_level, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorgrade_level, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorgrade_level, className: 'btn-sm btn-hero-danger'},
                ]
            });
        });
    </script>
@endsection