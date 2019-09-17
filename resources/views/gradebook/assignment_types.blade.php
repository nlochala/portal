@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $class->name }} - Assignment Types</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Assignment Types', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Assignment Types -->@include('_tables.new-table',['id' => 'assignment_types_table', 'table_head' => ['ID', 'Name', 'Description', 'Weight', 'Assigned Assignments']])
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

    <script type="text/javascript">

        jQuery(document).ready(function () {

            var editorassignment_types = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/class/'.$class->uuid.'/gradebook/assignment_type/ajaxstoreassignment_type') }}",
                table: "#assignment_types_table",
                idSrc: 'id',
                fields: [{
                    label: "Name:",
                    name: "name"
                }, {
                    label: "Description:",
                    name: "description"
                }, {
                    label: "Weight:",
                    name: "weight"
                },{
                    label: "class_id",
                    name: "class_id",
                    def: "{{ $class->id }}",
                    type: "hidden",
                }
                ]
            });

            var tableassignment_types = $('#assignment_types_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/class/'.$class->uuid.'/gradebook/assignment_type/ajaxshowassignment_type') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "description"},
                    {data: "weight"},
                    { data: "assignments",
                        render: function(data, type, row) {
                            return data.length;
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
                    {extend: "create", editor: editorassignment_types, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editorassignment_types, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editorassignment_types, className: 'btn-sm btn-hero-danger'},

                ]
            });

        });
    </script>
@endsection
