@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Attendance Report',
    'subtitle' => $quarter->name.' - '.$class->fullName,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Attendance Report Form',
            'page_uri'  => '/attendance/quarterly_report_form'
        ],
        [
            'page_name' => 'Attendance Report',
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
    @include('layouts._panels_start_panel', ['title' => 'Attendance Report', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF ATTENDANCE -->
    @if(empty($attendance))
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'attendance_table', 'table_head' => ['Name','Present','Absent','Unexcused Tardies']])
        @foreach($attendance as $name => $student)
            @if($student['present'] === $quarter->instructional_days && $student['tardies'] === 0)
                <tr bgcolor="#7fffd4">
            @else
                <tr>
            @endif
                    <td>{!! $name !!}</td>
                    <td>{{ $student['present'] }}</td>
                    <td>{{ $student['absent'] }}</td>
                    <td>{{ $student['tardies'] }}</td>
                </tr>
                @endforeach
                @include('_tables.end-new-table')
            @endif
            <br />
            <br />
            <strong><em>** Perfect attendance in <span style="background-color: #7fffd4">green</span>.</em></strong>
            @include('layouts._panels_end_content')
            @include('layouts._panels_end_panel')
            <!-------------------------------------------------------------------------------->
            <!-------------------------------------------------------------------------------->
            @include('layouts._panels_end_column')
            @include('layouts._panels_end_row')

            @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            var tableattendance = $('#attendance_table').DataTable({
                dom: "Bfrt",
                select: true,
                paging: false,
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
                ]
            });


        });
    </script>
@endsection
