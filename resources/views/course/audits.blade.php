@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $course->short_name.' - Audits',
    'subtitle' => $course->description,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Course Index',
            'page_uri'  => '/course/index'
        ],
        [
            'page_name' => $course->full_name,
            'page_uri'  => '/course/'.$course->uuid
        ],
        [
            'page_name' => $course->short_name.' - Audits',
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
    @include('layouts._panels_start_panel', ['title' => 'AUDITS', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF AUDITS -->@include('_tables.new-table',['id' => 'audit_table', 'table_head' => ['ID', 'Action', 'Performed By', 'Date', 'What Changed']])
    @foreach($audits as $audit)
        @php
            $meta = $audit->getMetadata();
            $modified = $audit->getModified();
        @endphp
        <tr>
            <td>{{ $meta['audit_id']  }}</td>
            <td>{{ $meta['audit_event']  }}</td>
            <td>{{ $meta['user_display_name'] }} ({{ $meta['user_username']  }})</td>
            <td>{{ $meta['audit_created_at'] }}</td>
            <td>
                @foreach($modified as $change => $value)
                    The field, <strong>{{ $change }}</strong> went from <strong>{{ var_export($value['old']) }}</strong>
                    --> <strong>{{ var_export($value['new']) }}</strong>. <br/>
                @endforeach
            </td>
        </tr>
    @endforeach
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
            var tableaudit = $('#audit_table').DataTable({
                dom: "Bfrtip",
                select: true,
                paging: true,
                pageLength: 50,
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
                    }
                ]
            });
        });
    </script>
@endsection