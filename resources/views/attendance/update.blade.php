@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => $date_iso,
    'subtitle' => 'Attendance Update - <small><em><a data-toggle="modal" data-target="#modal-block-date" href="#modal-block-date">Change Date</a></em></small>',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Attendance Daily Report',
            'page_uri'  => '/attendance/daily_report',
        ],
        [
            'page_name' => 'Update Attendance',
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
    @include('layouts._panels_start_panel', ['title' => 'Attendance', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Attendance -->@include('_tables.new-table',['id' => 'attendance_table', 'table_head' => ['ID', 'Name','Grade Level', 'Date', 'Status']])
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
    <!-------------------------------- Modal: Change Date Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-date',
        'title' => 'Change Date'
    ])
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'date',
        'label' => 'Historical Date',
        'format' => 'yyyy-mm-dd',
        'required' => true,
        'selected' => null
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Change Date END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-date". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">
        jQuery(document).ready(function () {

            var editorattendance = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/attendance/update/'.$date->format('Y-m-d').'/ajaxstoreattendance') }}",
                table: "#attendance_table",
                idSrc: 'id',
                fields: [
                {
                    label: "Attendance Type",
                    name: "attendance_type_id",
                    type: "select2",
                    opts: {
                        placeholder: "Choose One..."
                    },
                    options: [
                        @foreach($attendance_types as $attendance_type)
                        {
                            label: "{{ $attendance_type->name }}", value: "{{ $attendance_type->id }}"
                        },
                        @endforeach
                    ]
                },
                ]
            });

            // Activate an inline edit on click of a table cell
            $('#attendance_table').on('click', 'tbody td.editable', function (e) {
                editorattendance.inline(this, {
                    onBlur: 'submit'
                });
            });

            var tableattendance = $('#attendance_table').DataTable({
                dom: "Bfrtip",
                select: false,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/attendance/update/'.$date->format('Y-m-d').'/ajaxshowattendance') }}", "dataSrc": ""},
                keys: {
                    editor: editorattendance,
                },
                columns: [
                    {data: 'id'},
                    {data: "name"},
                    { data: "gradeLevel",
                        render: function(data, type, row) {
                            // IF EXPECTING A STRING
                            if (data === null) {
                                return '--'
                            }
                            return data.name
                        }
                    },
                    {data: "date"},
                    {
                        data: 'attendance_type_id',
                        className: 'editable',
                        render: function (data, type, row) {
                                // IF EXPECTING A STRING
                                if (row.attendanceDay === null) {
                                    return '--';
                                }
                                return row.attendanceDay.type.name
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
                        action: function ( e, dt, node, config ) {
                            this.disable();
                        }
                    },
                    {extend: "create", editor: editorattendance, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorattendance, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorattendance, className: 'btn-sm btn-hero-danger'},

                ]
            });


        });
    </script>
@endsection
