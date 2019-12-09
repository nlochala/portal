@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'STUDENT: '.$student->person->preferred_name.' '.$student->person->family_name,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/',
        ],
        [
            'page_name' => 'Student Dashboard',
            'page_uri'  => request()->getRequestUri(),
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
    @include('layouts._panels_start_column', ['size' => 6])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => $quarter->name.' Classes', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF CLASSES -->
    @if($classes->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'classes_table', 'table_head' => ['ID','Class','Current Grade']])
        @foreach($classes as $class)
            <tr>
                <td>{{ $class->id }}</td>
                <td>
                    <a href="/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}">{{ $class->fullName }}</a>
                </td>
                @php
                    $grade = $grades->where('class_id',$class->id)->first();
                @endphp
                @if(isset($grade))
                    <td>{!! App\Helpers\ViewHelpers::colorPercentages($grade->percentage, $grade->percentage.'% '.$grade->grade_name) !!}</td>
                @else
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

            <strong>{{ $quarter->name }} Absence Summary</strong>
            <!-- TABLE OF ABSENCES -->
            @if($absences->isEmpty())
                <br /><small><em>Student has not been absent during {{ $quarter->name }}.</em></small>
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

            @if ($student->family)
                @include('layouts._panels_start_row',['has_uniform_length' => false])
                @include('layouts._panels_start_column', ['size' => 8])

                @include('family._student_table', ['family' => $student->family, 'exclude' => $student->id])

                @include('layouts._panels_end_column')
                @include('layouts._panels_start_column', ['size' => 4])

                @include('family._guardian_table', ['family' => $student->family])

                @include('layouts._panels_end_column')
                @include('layouts._panels_end_row')
            @else
                <hr/>
                <h2 class="font-w400" style="text-align: center">{{ $student->person->fullName()}} does not have a
                    family.<br/>
                    @can('student.update.biographical')
                        <button style="width: 25%" class="btn btn-hero-lg btn-hero-primary"
                                onclick="location.href='/student/{{ $student->uuid }}/new_family'"
                                data-toggle="click-ripple">Add To Family
                        </button></h2>
                <hr/>
            @endcan
            @endif

            @if ($student->person->user)
                @include('layouts._panels_start_row',['has_uniform_length' => false])
                @include('layouts._panels_start_column', ['size' => 3])
                @include('user._ad_information', ['user' => $student->person->user])
                @include('layouts._panels_end_column')
                @include('layouts._panels_start_column', ['size' => 9])
                @include('user._ad_groups', ['user' => $student->person->user])
                @include('layouts._panels_end_column')
                @include('layouts._panels_end_row')
            @endif

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
