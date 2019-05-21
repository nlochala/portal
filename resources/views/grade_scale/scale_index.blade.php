@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Grade Scales',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Grade Scales',
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
    @include('layouts._panels_start_panel', ['title' => 'Grade Scales Management', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Grade Scales Management -->
    @include('_tables.new-table',['id' => 'grade_scales_table', 'table_head' => ['ID', 'Name', 'Description', 'Percentage-Based', 'Standards-Based', 'Actions']])
    @include('_tables.end-new-table')


    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')

    <!-------------------------------- Modal: New Grade Scale Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-grade-scale',
        'title' => 'New Grade Scale'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => false, 'id' => 'grade-scale-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New name text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'name',
        'label' => 'Name',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New description text field----------------------------->
    @include('layouts._forms._input_text',[
        'name' => 'description',
        'label' => 'Description',
        'placeholder' => '',
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!-----------------------New grade_scale_type_id radio------------------------------------->
    @include('layouts._forms._input_radio_inline',[
        'name' => 'grade_scale_type_id',
        'label' => 'Grade Scale Type',
        'array' => $type_radio,
        'required' => true,
        'selected' => null

    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->


    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: New Grade Scale END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-grade-scale". ----->
@endsection

@section('js_after')

    {!! JsValidator::formRequest('\App\Http\Requests\StoreGradeScaleRequest','#grade-scale-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var tablegrade_scale = $('#grade_scales_table').DataTable({
                dom: "frtip",
                select: true,
                paging: true,
                pageLength: 30,
                ajax: {"url": "/api/grade_scale/ajaxshowgrade_scale", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "description"},
                    {
                        data: "is_percentage_based",
                        render: function (data, type, row) {
                            // IF EXPECTING A STRING
                            if (data == false) {
                                return '';
                            }

                            return '<i class="fa fa-check-circle"></i>';
                        }
                    },
                    {
                        data: "is_standards_based",
                        render: function (data, type, row) {
                            // IF EXPECTING A STRING
                            if (data == false) {
                                return '';
                            }

                            return '<i class="fa fa-check-circle"></i>';
                        }
                    },
                    {
                        data: "uuid",
                        render: function (data, type, row) {
                            return "        <div class=\"btn-group\">\n" +
                                "            <button dusk=\"btn-show-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-info\" data-toggle=\"tooltip\" title=\"View Details\"\n" +
                                "                    onclick=\"window.location.href='/grade_scale/" + data + "'\">\n" +
                                "                <i class=\"si si-magnifier\"></i>\n" +
                                "            </button>\n" +
                                "            <button dusk=\"btn-archive-" + data + "\" type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-toggle=\"tooltip\" title=\"Delete\"\n" +
                                "                    onclick=\"window.location.href='/grade_scale/" + data + "/delete'\">\n" +
                                "                <i class=\"fa fa-times\"></i>\n" +
                                "            </button>\n" +
                                "        </div>"
                        }
                    }
                ]
            });
            new $.fn.dataTable.Buttons(tablegrade_scale, {
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
                    {
                        text: 'New',
                        className: 'btn-sm btn-hero-primary',
                        action: function ( e, dt, node, config ) {
                            $('#modal-block-grade-scale').modal('toggle');
                        }
                    },
                ]
            }).container().prependTo(tablegrade_scale.table().container());
        });
    </script>
@endsection