@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Courses',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Courses',
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
    @include('layouts._panels_start_panel', ['title' => 'Courses', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Courses -->@include('_tables.new-table',['id' => 'course_table', 'table_head' => ['ID', 'Abbreviation', 'Name', 'Type', 'Department', 'Active', 'Actions']])
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
        'id' => 'modal-block-course',
        'title' => 'New Course'
    ])

    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'course-form','url' => request()->getRequestUri()]) !!}
    @include('course._course_form')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Course END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-course". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreCourseRequest','#course-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#course_type_id").select2({ placeholder: "Choose One..." });
            $("#grade_scale_id").select2({ placeholder: "Choose One..." });
            $("#department_id").select2({ placeholder: "Choose One..." });
            $("#course_transcript_type_id").select2({ placeholder: "Choose One..." });

            $("#grade_levels").select2({placeholder: "Choose One..."});
            $('#grade_levels').trigger('change'); // Notify any JS components that the value changed

            var tablecourse = $('#course_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/course/ajaxshowcourse') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "short_name"},
                    {data: "name"},
                    {data: "type.name"},
                    {data: "department.name"},
                    {
                        data: "is_active",
                        render: function (data, type, row) {
                            if (data === true) {
                                return '<i class="fa fa-check-circle"></i>';
                            }
                            return '';
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "    <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/course/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-edit-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-primary\" data-toggle=\"tooltip\" title=\"Edit\"\n" +
                                "                    onclick=\"window.location.href='/course/" + data + "/edit'\">\n" +
                                "                <i class=\"fa fa-pen\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-archive-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-toggle=\"tooltip\" title=\"Archive\"\n" +
                                "                    onclick=\"window.location.href='/course/" + data + "/archive'\">\n" +
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
                            $('#modal-block-course').modal('toggle');
                        }
                    },
                ]
            });
        });
    </script>
@endsection
