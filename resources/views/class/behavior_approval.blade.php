@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Behavior Approvals - '.$quarter->name,
    'subtitle' => '<small><em><a data-toggle="modal" data-target="#modal-block-quarter" href="#modal-block-quarter">Change Quarter</a></em></small>',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Behavior Approvals',
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
    @include('layouts._panels_start_panel', ['title' => 'Approve Behavior Grades', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Approve Behavior Grades -->@include('_tables.new-table',['id' => 'grade_table', 'table_head' => ['Student', 'Grade Level', 'Behavior Grade', 'Comment', 'Approved']])
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
    <!-------------------------------- Modal: Change Quarter Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-quarter',
        'title' => 'Change Quarter'
    ])
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New quarter_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'quarter_id',
        'label' => 'Quarter',
        'array' => $quarter_dropdown,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Change Quarter END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-quarter". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var editorgrade = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/report/behavior/approve/'.$quarter->uuid.'/ajaxstorereports') }}",
                table: "#grade_table",
                idSrc: 'id',
                fields: [
                    {
                        label: "Behavior Grade",
                        name: "grade_scale_item_id",
                        type: "select2",
                        opts: {
                            placeholder: "Choose One..."
                        },
                        options: [
                                @foreach($grade_scale_dropdown as $id => $name)
                            {
                                label: "{{ $name }}", value: "{{ $id }}"
                            },
                            @endforeach
                        ]
                    },
                    {
                        label: 'Comments',
                        name: 'comment',
                        type: 'textarea'
                    }, {
                        label: "Approved:",
                        name: "is_approved",
                        type: "radio",
                        options: [
                            {label: "Yes", value: "1"},
                            {label: "No", value: "0"},
                        ],
                        def: 0
                    }
                ]
            });

            // Activate an inline edit on click of a table cell
            $('#grade_table').on('click', 'tbody td.editable', function (e) {
                editorgrade.inline(this, {
                    onBlur: 'submit'
                });
            });

            var tablegrade = $('#grade_table').DataTable({
                dom: "Bfrtip",
                select: false,
                paging: true,
                pageLength: 50,
                ajax: {
                    "url": "{{ url('api/report/behavior/approve/'.$quarter->uuid.'/ajaxshowreports') }}",
                    "dataSrc": ""
                },
                keys: {
                    editor: editorgrade,
                },
                columns: [
                    {
                        data: 'student.person',
                        render: function (data, type, row) {
                            if (data.given_name === data.preferred_name) {
                                return data.given_name+' '+data.family_name;
                            }

                            return data.given_name+' '+data.family_name+' ('+data.preferred_name+')';
                        }
                    },
                    {
                        data: "student.grade_level",
                        render: function (data, type, row) {
                            return data.name
                        }
                    },
                    {
                        data: 'grade_scale_item_id',
                        className: 'editable',
                        render: function (data, type, row) {
                            return row.item.name;
                        }
                    },
                    {
                        data: 'comment',
                        className: 'editable',
                    },
                    {
                        data: "is_approved",
                        className: 'editable',
                        render: function (data, type, row) {
                            if (data === 0 || data === "0") {
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
                    {extend: "create", editor: editorgrade, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorgrade, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorgrade, className: 'btn-sm btn-hero-danger'},

                ]
            });


        });
    </script>
@endsection
