@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => $student->name.' - '.$quarter->name.' Grade Report',
    'subtitle' => $class->fullName(true),
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Class Gradebook',
            'page_uri'  => "/class/$class->uuid/$quarter->uuid/gradebook"
        ],
        [
            'page_name' => 'Student Report',
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
    <div style="text-align: right">
        <button type="button" class="btn btn-hero-primary btn-hero-sm mb-2 d-print-none"
                onclick="window.location.href='/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}/print'">
            <i class="si si-printer mr-1"></i> Print Report
        </button>
    </div>
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Grades By Type', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF TYPES -->
    @if($assignment_types->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'types_table', 'table_head' => ['Type and Weight', 'Quarter 1','Quarter 2', 'Quarter 3', 'Quarter 4']])
        @foreach($summary_array as $type_name => $averages)
            <tr>
                @if ($type_name === 'TOTAL')
                    <td bgcolor="#fafad2">{{ $type_name }}</td>
                    @foreach($quarters as $q)
                        <td bgcolor="#fafad2"><strong>{!! $averages[$q->name] !!}</strong></td>
                    @endforeach
                @else
                    <td>{{ $type_name }}</td>
                    @foreach($quarters as $q)
                        <td><strong>{!! $averages[$q->name] !!}</strong></td>
                    @endforeach
                @endif
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

    @foreach($assignment_types as $type)
        @include('layouts._panels_start_row',['has_uniform_length' => true])
        @include('layouts._panels_start_column', ['size' => 12])
        <!-------------------------------------------------------------------------------->
        <!----------------------------------New Panel ------------------------------------>
        @include('layouts._panels_start_panel', ['title' => $type->name, 'with_block' => false])
        {{-- START BLOCK OPTIONS panel.block --}}
        @include('layouts._panels_start_content')
        <!-- TABLE OF ASSIGNMENTS -->
        @if($type->assignments()->where('quarter_id',$quarter->id)->get()->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'assignment_id', 'table_head' => ['Name','Date Assigned','Points Earned', 'Percentage', 'Date Turned In']])
            @foreach($type->assignments()->where('quarter_id',$quarter->id)->get() as $assignment)
                <tr>
                    <td>{{ $assignment->name }}</td>
                    <td>{{ $assignment->date_assigned }}</td>
                    @if (isset($assignment->grades->where('student_id', $student->id)->first()->points_earned) && $assignment->grades->where('student_id', $student->id)->first()->points_earned !== null)
                        <td>{{ $assignment->grades->where('student_id', $student->id)->first()->points_earned }}
                            /{{ $assignment->max_points }}</td>
                        @php
                            $p = round(($assignment->grades->where('student_id', $student->id)->first()->points_earned/$assignment->max_points)*100,2)
                        @endphp
                        @if($p <= 70)
                            <td bgcolor="#FFE5EE">
                                {{ $p }}%
                            </td>
                        @else
                            <td>
                                {{ $p }}%
                            </td>
                        @endif
                        <td>{{ $assignment->grades->where('student_id',$student->id)->first()->date_completed }}</td>
                    @else
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    @endif
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
    @endforeach
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
