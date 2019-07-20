@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Classes',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Class',
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
    @include('layouts._panels_start_panel', ['title' => 'Classes', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Class -->@include('_tables.new-table',['id' => 'classes_table', 'table_head' => ['ID', 'Name', 'Status', 'Room', 'Teachers', 'Actions']])
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
    <!-------------------------------- Modal: New Class Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-classes',
        'title' => 'New Class'
    ])

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'classes-form','url' => request()->getRequestUri()]) !!}
    @include('class._class_form')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Class END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-classes". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreClassRequest','#classes-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#primary_employee_id").select2({ placeholder: "Choose One..." });
            $("#secondary_employee_id").select2({ placeholder: "Choose One...", allowClear: true });
            $("#ta_employee_id").select2({ placeholder: "Choose One...", allowClear: true });
            $("#course_id").select2({ placeholder: "Choose One..." });
            $("#room_id").select2({ placeholder: "Choose One..." });

            var tableclasses = $('#classes_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/class/ajaxshowclass') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    { data: "name",
                        render: function(data, type, row) {
                            return row.course.short_name + ': ' + data;
                        }
                    },
                    {data: "status",
                        render: function(data, type, row) {
                            let status;
                            let text = data.name + ' - ' + row.year.year_start+'-'+row.year.year_end;

                            switch (data.id) {
                                case 1:
                                    status = '<span class="badge badge-primary"><i class=""></i>'+text+'</span>';
                                    break;
                                case 2:
                                    status = '<span class="badge badge-success"><i class=""></i>'+text+'</span>';
                                    break;
                                case 3:
                                    status = '<span class="badge badge-warning"><i class=""></i>'+text+'</span>';
                                    break;
                                default:
                                    status = text;
                            }

                            return status;
                        }
                    },
                    {data: "room",
                        render: function(data, type, row) {
                            return data.building.short_name + data.number;
                        }
                    },
                    {data: "primary_employee",
                        render: function(data, type, row) {
                            let teachers;
                            teachers = '<strong>Primary Teacher:</strong> '+employeeName(data);
                            if(row.secondary_employee !== null) {
                                teachers += '<br /><strong>Secondary Teacher:</strong> '+employeeName(row.secondary_employee);
                            }
                            if(row.ta_employee !== null) {
                                teachers += '<br /><strong>Teaching Assistant:</strong> '+employeeName(row.ta_employee);
                            }
                            return teachers;
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/class/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/class/" + data + "/edit_overview'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-archive-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-toggle=\"tooltip\" title=\"Archive\"\n" +
                                "                    onclick=\"window.location.href='/class/" + data + "/archive'\">\n" +
                                "                <i class=\"fa fa-times\"></i>\n" +
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
                    {
                        text: 'New',
                        className: 'btn-sm btn-hero-primary',
                        action: function ( e, dt, node, config ) {
                            $('#modal-block-classes').modal('toggle');
                        }
                    },
                ]
            });
        });
    </script>
@endsection
