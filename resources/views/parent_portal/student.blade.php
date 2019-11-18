@extends('layouts.backend_guardian')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Student',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Student',
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
    @include('layouts._panels_start_column', ['size' => 8])

    @include('student._info_panel_large')

    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])

    @include('person._profile_image', ['person' => $student->person])

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    {{--    STUDENT CLASSES    --}}
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Grades and Classes', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF CLASSES -->
    @if(empty($grades_summary_array))
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'classes_table', 'table_head' => $grades_header])
        @foreach($grades_summary_array as $class => $grade)
            <tr>
                <td>
                    {!! $class !!}
                </td>
                @foreach($quarters as $q)
                    @if(!$grade[$q->name]['badge'])
                        <td>--</td>
                    @else
                        <td>{!! $grade[$q->name]['badge'] ?? '--' !!} {!! $grade[$q->name]['link'] !!}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif

    <small>** {{ $quarter->name }} is the current quarter, these grades will change.</small>
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Attendance Summary', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <strong>Year Summary</strong>
    <!-- TABLE OF ATTENDANCE -->
    @if(!isset($attendance_summary_array) || empty($attendance_summary_array))
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'summary_table', 'table_head' => ['', 'Q1', 'Q2', 'Q3', 'Q4', 'TOTAL']])
        @foreach($attendance_summary_array as $key => $quarters)
            @if($key === 'Instructional Days')
                <tr bgcolor="#ffe4c4">
            @else
                <tr>
                    @endif
                    <td>{{ $key }}</td>
                    @php
                        $sum = 0;
                    @endphp
                    @foreach($quarters as $count)
                        @php
                            $sum += $count;
                        @endphp
                        <td>{{ $count }}</td>
                    @endforeach
                    <td>{{ $sum }}</td>
                </tr>
                @endforeach
                @include('_tables.end-new-table')
            @endif

            @include('layouts._panels_end_content')
            @include('layouts._panels_end_panel')
            <!-------------------------------------------------------------------------------->
            <!-------------------------------------------------------------------------------->
            @include('layouts._panels_end_column')
            @include('layouts._panels_start_column', ['size' => 6])
            <!-------------------------------------------------------------------------------->
            <!----------------------------------New Panel ------------------------------------>
            @include('layouts._panels_start_panel', ['title' => 'Absence Details', 'with_block' => false])
            {{-- START BLOCK OPTIONS panel.block --}}
            @include('layouts._panels_start_content')
            <!-- TABLE OF ABSENCES -->
            @if($absences->isEmpty())
                <br/><small><em>Student has not been absent.</em></small>
            @else
                @include('_tables.new-table',['id' => 'absence_table', 'table_head' => ['Date','Reason']])
                @foreach($absences as $absence)
                    <tr>
                        <td>{{ $absence->date }}</td>
                        <td>{{ $absence->type->name }}</td>
                    </tr>
                @endforeach
                @include('_tables.end-new-table')
            @endif
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


        });
    </script>
@endsection
