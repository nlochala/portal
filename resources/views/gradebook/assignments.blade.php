@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">Assignments</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Assignments', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Assignments -->@include('_tables.new-table',['id' => 'assignments_table', 'table_head' => ['ID', 'Name', 'Type', 'Quarter','Date Assigned', 'Date Due','Max Points Allowed','Actions']])
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

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var editorassignments = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/class/'.$class->uuid.'/'.$quarter->uuid.'/gradebook/assignment/ajaxstoreassignment') }}",
                table: "#assignments_table",
                idSrc: 'id',
                fields: [
                    {
                        label: "Assignment Type",
                        name: "assignment_type_id",
                        type: "select2",
                        opts: {
                            placeholder: "Choose One..."
                        },
                        options: [
                                @foreach($assignment_types as $id => $name)
                            {
                                label: "{{ $name }}", value: "{{ $id }}"
                            },
                            @endforeach
                        ]
                    }, {
                        label: "Quarter",
                        name: "quarter_id",
                        def: {{ $quarter->id }},
                        type: "select2",
                        opts: {
                            placeholder: "Choose One..."
                        },
                        options: [
                                @foreach($quarters as $id => $name)
                            {
                                label: "{{ $name }}", value: "{{ $id }}"
                            },
                            @endforeach
                        ]
                    }, {
                        label: "Name:",
                        name: "name"
                    }, {
                        label: "Description:",
                        name: "description",
                        type: "textarea"
                    }, {
                        label: "Date Assigned:",
                        name: "date_assigned",
                        type: "datetime",
                        opts: {
                            showOn: 'focus',
                            format: 'YYYY-MM-DD'
                        }
                    }, {
                        label: "Date Due:",
                        name: "date_due",
                        type: "datetime",
                        opts: {
                            showOn: 'focus',
                            format: 'YYYY-MM-DD'
                        }
                    }, {
                        label: "Max Points:",
                        name: "max_points"
                    }, {
                        label: "Display On Parent Portal",
                        name: "can_display",
                        type: "radio",
                        def: 1,
                        options: [
                            { label: 'Yes', value: 1 },
                            { label: 'No', value: 0 }
                        ]
                    }, {
                        label: "class_id",
                        name: "class_id",
                        def: "{{ $class->id }}",
                        type: "hidden",
                    }
                ]
            });

            var tableassignments = $('#assignments_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {
                    "url": "{{ url('api/class/'.$class->uuid.'/'.$quarter->uuid.'/gradebook/assignment/ajaxshowassignment') }}",
                    "dataSrc": ""
                },
                columns: [
                    {data: "id"},
                    {
                        data: "name",
                        render: function (data, type, row) {
                            return "<a href='/class/{{ $class->uuid }}/{{ $quarter->uuid }}/gradebook/assignment/"+row.uuid+"'>"+data+"</a>";
                        }
                    },
                    {data: "type.name"},
                    {data: "quarter.name"},
                    {data: "date_assigned"},
                    {data: "date_due"},
                    {data: "max_points"},
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/class/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                "        </div>"
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
                    {extend: "create", editor: editorassignments, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorassignments, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorassignments, className: 'btn-sm btn-hero-danger'},

                ]
            });


        })
        ;
    </script>
@endsection
