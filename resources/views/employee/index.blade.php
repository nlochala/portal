@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Employees',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Employee Index',
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
    @include('layouts._panels_start_panel', ['title' => 'Employees', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Courses -->@include('_tables.new-table',['id' => 'employee_table', 'table_head' => ['ID', 'Name', 'Status','Classification', 'Email', 'Phone', 'Actions']])
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
    <!-------------------------------- Modal: New Course Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-employee',
        'title' => 'New Employee'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'employee-form','url' => request()->getRequestUri()]) !!}
    @include('layouts._forms._heading',['title' => 'Employment Overview'])
    <!----------------------------------------------------------------------------->
    <!---------------------------New school_email text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'email_school',
        'label' => 'School Email',
        'placeholder' => 'xxxx@tlcdg.com',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('employee._overview_form')
    @include('layouts._forms._heading',['title' => 'Biographical'])
    @include('person._create_form_biographical', ['type' => 'employee'])
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Course END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-employee". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreEmployeeRequest','#employee-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#dob').datepicker();
            $('#start_date').datepicker();
            $('#end_date').datepicker();
            $('#employee_status_id').select2();

            var tableemployee = $('#employee_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/employee/ajaxshowemployee') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "person",
                        render: function(data, type, row) {
                            let name = data.family_name+', '+data.given_name;
                            if (data.name_in_chinese !== null) {
                                name += ' '+data.name_in_chinese;
                            }
                            if (data.preferred_name !== null && data.preferred_name !== data.given_name) {
                                name += ' ('+data.preferred_name+')';
                            }
                            return name;
                        }
                    },
                    {data: "status",
                        render: function (data, type, row) {
                            if (data === null) {
                                return '--';
                            }

                            return data.name;
                        }
                    },
                    {data: "classification",
                        render: function (data, type, row) {
                            if (data === null) {
                                return '--';
                            }

                            return data.name;
                        }
                    },
                    {
                        data: "person",
                        render: function (data, type, row) {
                            let return_string = '';
                            if (data.email_primary !== null) {
                                return_string += '<strong>Primary Email:</strong> '+"<a href=\"mailto:" + data.email_primary + "\">" + data.email_primary + "</a>";
                                if (data.email_secondary !== null || data.email_school !== null) {
                                    return_string += '<br />';
                                }
                            }
                            if (data.email_secondary !== null) {
                                return_string += '<strong>Secondary Email:</strong> '+"<a href=\"mailto:" + data.email_secondary + "\">" + data.email_secondary + "</a>";
                                if (data.email_school !== null) {
                                    return_string += '<br />';
                                }
                            }
                            if (data.email_school !== null) {
                                return_string += '<strong>School Email:</strong> '+"<a href=\"mailto:" + data.email_school + "\">" + data.email_school + "</a>";
                            }

                            if (return_string.length === 0) {
                                return '--';
                            }

                            return return_string;
                        }
                    },
                    {
                        data: "person.phones",
                        render: function (data, type, row) {
                            if (data.length === 0) {
                                return '--';
                            }

                            let return_string = '';

                            data.forEach(function (item, index) {
                                if (index === 0) {
                                    return_string += '<strong>'+item.phone_type.name+':</strong> ( +'+item.country.country_code+') '+item.number;
                                    if (item.extension !== null) {
                                        return_string += ' (ext. '+item.extension+')';
                                    }
                                } else {
                                    return_string += '<br /><strong>'+item.phone_type.name+':</strong> (+'+item.country.country_code+') '+item.number;
                                    if (item.extension !== null) {
                                        return_string += ' (ext. '+item.extension+')';
                                    }
                                }
                            });
                            return return_string;
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/employee/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                @can('employees.show.full_profile')
                                "            </button>\n" +
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/employee/" + data + "/profile'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                @endcan
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
                    @can('employees.create.employees')
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
                            $('#modal-block-employee').modal('toggle');
                        }
                    },
                    @endcan
                ]
            });
        });
    </script>
@endsection
