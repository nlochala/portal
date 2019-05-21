@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $grade_scale->name,
    'subtitle' => $grade_scale->description,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Grade Scale - Index',
            'page_uri'  => '/grade_scale/index'
        ],
        [
            'page_name' => $grade_scale->name,
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
    @include('layouts._panels_start_panel', ['title' => 'Grade Scale Items', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Grade Scale Items -->@include('_tables.new-table',['id' => 'item_table', 'table_head' => ['ID', '% From', '% To', 'Resulting Grade', 'Equivalent Standard']])
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
            var editoritem = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/grade_scale/'.$grade_scale->uuid.'/'.$grade_scale->getScaleType().'/ajaxstoreitem') }}",
                table: "#item_table",
                idSrc: 'id',
                fields: [{
                    label: "% From:",
                    name: "from"
                }, {
                    label: "% To:",
                    name: "to"
                }, {
                    label: "Resulting Grade:",
                    name: "result",
                }, {
                    label: "Equivalent Standard",
                    name: "equivalent_standard_id",
                    type: "select2",
                    opts: {
                        placeholder: "Choose One..."
                    },
                    options: [
                            @foreach($equivalent_standards as $equivalent_standard)
                        {
                            label: "{{ $equivalent_standard->name }}", value: "{{ $equivalent_standard->id }}"
                        },
                        @endforeach
                    ]
                }, {
                    type: 'hidden',
                    name: 'grade_scale_id',
                    default: '{{ $grade_scale->id }}'
                }
                ]
            });

            var tableitem = $('#item_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/grade_scale/'.$grade_scale->uuid.'/'.$grade_scale->getScaleType().'/ajaxshowitem') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "from"},
                    {data: "to"},
                    {data: "result"},
                    {data: "standard.name"},
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
                    {extend: "create", editor: editoritem, className: 'btn-sm btn-hero-primary'},
                    {extend: "edit", editor: editoritem, className: 'btn-sm btn-hero-primary'},
                    {extend: "remove", editor: editoritem, className: 'btn-sm btn-hero-danger'},

                ]
            });


        });
    </script>
@endsection