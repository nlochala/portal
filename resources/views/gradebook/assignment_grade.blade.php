@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $assignment->name }}
        <br/><em><small><small>{{ $assignment->description }}</small></small></em>
    </h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Assessments', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Assessments -->@include('_tables.new-table',['id' => 'assessments_table', 'table_head' => ['Name', 'Points Earned', 'Total Possible', 'Percentage %','Date Completed','Excused']])
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

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            var editorassessments = new $.fn.dataTable.Editor({
                ajax: "{{ url("api/class/$class->uuid/$quarter->uuid/gradebook/assignment/$assignment->uuid/ajaxstoreassessment") }}",
                table: "#assessments_table",
                idSrc: 'id',
                fields: [{
                    label: "Points Earned:",
                    name: "points_earned"
                }, {
                    label: "Notes:",
                    name: "notes"
                }, {
                    label: "Date Completed:",
                    name: "date_completed",
                    type: "datetime",
                    opts: {
                        showOn: 'focus',
                        format: 'YYYY-MM-DD'
                    }
                }, {
                    label: "Excused:",
                    name: "is_excused",
                    type: "radio",
                    options: [
                        {label: "True", value: "1"},
                        {label: "False", value: "0"},
                    ],
                    def: 0
                }
                ]
            });

            // Activate an inline edit on click of a table cell
            $('#assessments_table').on('click', 'tbody td.editable', function (e) {
                editorassessments.inline(this, {
                    onBlur: 'submit'
                });
            });

            var tableassessments = $('#assessments_table').DataTable({
                dom: "Bfrtip",
                select: false,
                paging: true,
                pageLength: 50,
                ajax: {
                    "url": "{{ url("api/class/$class->uuid/$quarter->uuid/gradebook/assignment/$assignment->uuid/ajaxshowassessment") }}",
                    "dataSrc": ""
                },
                keys: {
                    editor: editorassessments,
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="/student/' + row.student.uuid + '">' + row.student.person.preferred_name + ' ' + row.student.person.family_name + '</a>';
                        }
                    },
                    {
                        data: "points_earned",
                        className: 'editable',
                        render: function (data, type, row) {
                            if (row.is_excused || data === null) {
                                return '--';
                            }
                            return data;
                        }
                    },
                    {
                        data: "assignment.max_points",
                        render: function (data, type, row) {
                            if (row.is_excused) {
                                return '--';
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            if (row.points_earned === null || row.is_excused) {
                                return '--';
                            }
                            $number = parseFloat(row.points_earned) / parseInt(row.assignment.max_points) * 100;
                            return $number + '%';
                        }
                    },
                    {
                        data: "date_completed",
                        className: 'editable',
                        render: function (data, type, row) {
                            if (row.is_excused || data === null) {
                                return '--';
                            }
                            return data;
                        }
                    },
                    {
                        data: "is_excused",
                        className: 'editable',
                        render: function (data, type, row) {
                            if (! data) {
                                return '--';
                            }
                            return '<i class="fa fa-check-circle"></i>';
                        }
                    }
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
                    {extend: "create", editor: editorassessments, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorassessments, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorassessments, className: 'btn-sm btn-hero-danger'},

                ]
            });

        });
    </script>
@endsection
