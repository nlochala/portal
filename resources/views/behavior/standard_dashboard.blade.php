@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $standard->name,
    'subtitle' => $standard->description,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Behavior Standards - Index',
            'page_uri'  => '/behavior/standard/index'
        ],
        [
            'page_name' => $standard->name,
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
    @include('behavior._standard_update_form')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Standard Items', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF Grade Scale Items -->@include('_tables.new-table',['id' => 'item_table', 'table_head' => ['ID', 'Name', 'Description', 'Value']])
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

    {!! JsValidator::formRequest('\App\Http\Requests\StoreBehaviorStandardRequest','#standard-form') !!}

    <script type="text/javascript">
        jQuery(document).ready(function () {

            var editoritem = new $.fn.dataTable.Editor({
                ajax: "{{ url('api/behavior/standard/'.$standard->uuid.'/ajaxstoreitem') }}",
                table: "#item_table",
                idSrc: 'id',
                fields: [{
                    label: "Name:",
                    name: "name"
                }, {
                    label: "Description:",
                    name: "description"
                }, {
                    label: "Numeric Value (Number between 1 and 4):",
                    name: "value",
                }, {
                    type: 'hidden',
                    name: 'behavior_standard_id',
                    default: '{{ $standard->id }}'
                }
                ]
            });

            var tableitem = $('#item_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
                ajax: {"url": "{{ url('api/behavior/standard/'.$standard->uuid.'/ajaxshowitem') }}", "dataSrc": ""},
                columns: [
                    {data: "id"},
                    {data: "name"},
                    {data: "description"},
                    {data: "value"},
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
