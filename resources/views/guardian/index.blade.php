@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Guardians',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Guardian Index',
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
    @include('layouts._panels_start_panel', ['title' => 'Guardians', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Guardians -->@include('_tables.new-table',['id' => 'guardian_table', 'table_head' => ['ID', 'Name', 'Type', 'Email', 'Mobile Number', 'Actions']])
{{--    <!-- TABLE OF Guardians -->@include('_tables.new-table',['id' => 'guardian_table', 'table_head' => ['ID', 'Name', 'Preferred Name', 'Type', 'Email', 'Mobile Number', 'Actions']])--}}
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
    <!-------------------------------- Modal: New Guardian Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-guardian-employee',
        'title' => 'New Guardian - Based On Existing Employee'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'guardian-employee-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New guardian_type_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'employee_guardian_type_id',
        'label' => 'Guardian Type',
        'array' => $type_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New employee dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'employee_id',
        'label' => 'Employees',
        'array' => $employee_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->

    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Guardian END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-guardian". ----->
    <!-------------------------------- Modal: New Guardian Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-guardian',
        'title' => 'New Guardian'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'guardian-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New guardian_type_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'guardian_type_id',
        'label' => 'Guardian Type',
        'array' => $type_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('person._create_form_biographical', ['type' => 'guardian'])
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Guardian END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-guardian". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianRequest','#guardian-form') !!}
    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianEmployeeRequest','#guardian-employee-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#employee_guardian_type_id').select2();
            $('#guardian_type_id').select2();
            $('#employee_id').select2();
            $('#title').select2();

            var tableguardian = $('#guardian_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/guardian/ajaxshowguardian') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {
                        data: "person",
                        render: function (data, type, row) {
                            let name = data.title + ' ' + data.family_name + ', ' + data.given_name;
                            if (data.name_in_chinese !== null) {
                                name += ' ' + data.name_in_chinese;
                            }
                            if (data.preferred_name !== null && data.preferred_name !== data.given_name) {
                                name += ' (' + data.preferred_name + ')';
                            }
                            return name;
                        }
                    },
                    {data: "type.name"},
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
                                return '--'
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
                            let $return_string = '';
                            $return_string = "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/guardian/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                @can('guardians.show.full_profile')
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/guardian/" + data + "/profile'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                @endcan
                                "            <button dusk=\"btn-family-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-success\" data-toggle=\"tooltip\" title=\"View Family\"\n" +
                                "                    onclick=\"window.location.href='/guardian/" + data + "/view_family'\">\n" +
                                "                <i class=\"fa fa-users\"></i>\n" +
                                "            </button>\n" +
                                "        </div>";

                        @canImpersonate
                            if (row.person.user !== null) {
                                let id = row.person.user.id;
                                    $return_string += "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-toggle=\"tooltip\" title=\"IMPERSONATE\"\n" +
                                    "                    onclick=\"window.location.href='/impersonate/take/" + id + "'\">\n" +
                                    "                <i class=\"fa fa-street-view\"></i>\n" +
                                    "            </button>\n";
                            }
                        @endCanImpersonate

                            return $return_string;
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
                        @can('guardians.create.guardians')
                    {
                        text: '',
                        className: 'btn-sm btn-light',
                        action: function (e, dt, node, config) {
                            this.disable();
                        }
                    },
                    {
                        extend: 'collection',
                        text: 'NEW',
                        buttons: [
                            {
                                text: 'New Guardian',
                                action: function (e, dt, node, config) {
                                    $('#modal-block-guardian').modal('toggle');
                                }
                            },
                            {
                                text: 'New Guardian - Based On Existing Employee',
                                action: function (e, dt, node, config) {
                                    $('#modal-block-guardian-employee').modal('toggle');
                                }
                            },
                        ],
                        fade: true,
                        className: 'btn-sm btn-hero-primary'
                    },
                    @endcan
                ]
            });
        });
    </script>
@endsection
