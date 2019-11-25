@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Students',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Student Index',
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
    @include('layouts._panels_start_panel', ['title' => 'Students', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Courses -->@include('_tables.new-table',['id' => 'student_table', 'table_head' => ['ID', 'Name', 'Status','Data of Birth', 'Grade Level', 'Actions']])
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
        'id' => 'modal-block-student',
        'title' => 'New Student'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'student-form','url' => request()->getRequestUri()]) !!}
    @include('layouts._forms._heading',['title' => 'Academics'])
    @include('student._academic_overview_form')
    @include('layouts._forms._heading',['title' => 'Biographical'])
    @include('person._create_form_biographical', ['type' => 'student'])
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Course END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-student". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentRequest','#student-form') !!}


    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('#dob').datepicker();
            $('#start_date').datepicker();
            $('#end_date').datepicker();
            $('#student_status_id').select2();
            $('#grade_level_id').select2();

            var tablestudent = $('#student_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/student/ajaxshowstudent') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    { data: "person",
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
                    {data: "status.name"},
                    {data: "person.dob",
                        render: function(data, type, row) {
                            return formatDate(data)+' ('+getAge(data)+' Years Old)';
                        }
                    },
                    {data: "grade_level.short_name"},
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            let $return_string = '';
                            $return_string = "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/student/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                @can('students.show.full_profile')
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/student/" + data + "/profile'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                @endcan
                                "            <button dusk=\"btn-family-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-success\" data-toggle=\"tooltip\" title=\"View Family\"\n" +
                                "                    onclick=\"window.location.href='/student/" + data + "/view_family'\">\n" +
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
                        @can('students.create.students')
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
                            $('#modal-block-student').modal('toggle');
                        }
                    },
                    @endcan
                ]
            });
        });
    </script>
@endsection
