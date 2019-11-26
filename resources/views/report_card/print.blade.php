@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
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
    @foreach($students as $student)
        <div style="text-align: center">
            <img src="/storage/report_card_20192020_head.png" class="img-fluid options-item">
        </div>
        <br/>
        <br/>
        <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">
            {{ $student->person->family_name }}, {{ $student->person->given_name }} @if($student->person->preferred_name !== $student->person->given_name)
                ({{ $student->person->preferred_name }})@endif
        </h1>
            <table style="width: 100%">
            <tr>
                <td>
                        <h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">
                            <small>{{ $student->gradeLevel->name }}</small>
                        <br/>
                            <small>DOB: {{ $student->person->dob->format('Y-m-d') }}</small>
                    </h1>
                </td>
                <td align="right">
                    <h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">
                        <small>{{ $homeroom[$student->id]->fullName }}</small>
                        <br/>
                        <small>{{ $homeroom[$student->id]->primaryEmployee->full_name }}</small>
                    </h1>
                </td>
            </tr>
        </table>

        <br/>
        <h1 class="flex-sm-fill font-size-h4 font-w400 mt-2 mb-0 mb-sm-2">ATTENDANCE</h1>
        <!-- TABLE OF ATTENDANCE -->
        @if($student->reportCardPercentages->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'attendance_table', 'style' => 'border: 1px solid lightgray', 'table_head' => ['Quarter','Present','Absent','Unexcused Tardies', '']])
            @foreach($student->reportCardPercentages as $report)
                <tr>
                    <td>{{ $report->quarter->name }}</td>
                    <td>{{ $report->days_present }}</td>
                    <td>{{ $report->days_absent }}</td>
                    <td>{{ $report->days_tardy }}</td>
                    @if ($report->days_present == $report->quarter->instructional_days && $report->days_tardy == 0)
                        <td><strong><span style="color: #1a5c9b">PERFECT ATTENDANCE!!</span></strong></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
            @include('_tables.end-new-table')
        @endif

        <br/>
        <h1 class="flex-sm-fill font-size-h4 font-w400 mt-2 mb-0 mb-sm-2">CLASS GRADES</h1>
        <!-- TABLE OF GRADES -->
        @if(empty($grades[$student->id]))
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'grades_table', 'style' => 'border: 1px solid lightgray', 'table_head' => ['','Quarter 1','Quarter 2','Quarter 3','Quarter 4']])
            @foreach($grades[$student->id] as $name => $grade)
                <tr>
                    <td>{{ $name }}</td>
                    @foreach($quarters as $q)
                        <td>{{ $grade[$q->id] ?? '--'}}</td>
                    @endforeach
                </tr>
            @endforeach
            @include('_tables.end-new-table')
        @endif

        <br/>
        <h1 class="flex-sm-fill font-size-h4 font-w400 mt-2 mb-0 mb-sm-2">STUDENT BEHAVIOR</h1>
        <!-- TABLE OF ATTENDANCE -->
        @if(!isset($behavior_scale) || $behavior_scale->items->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'behavior_table', 'style' => 'border: 1px solid lightgray', 'table_head' => ['Quarter','Class','Grade','Comment']])
            @foreach($student->behaviorGrades->where('quarter_id', $quarter->id) as $behavior)
                <tr>
                    <td>{{ $behavior->quarter->name ?? '--'}}</td>
                    <td style="width: 25%">{{ $homeroom[$student->id]->fullName }}</td>
                    <td>{{ $behavior->item->short_name ?? '--'}}</td>
                    <td>{{ $behavior->comment  ?? '--'}}</td>
                </tr>
            @endforeach
            @include('_tables.end-new-table')
        @endif

        <br/>
        <h1 class="flex-sm-fill font-size-h4 font-w400 mt-2 mb-0 mb-sm-2">BEHAVIOR GRADING SCALE</h1>
        <!-- TABLE OF SCALE -->
        @if(!isset($behavior_scale) || $behavior_scale->items->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'scale_table_1', 'style' => 'border: 1px solid lightgray', 'table_head' => ['Abbreviation','Name','Description']])
            @foreach($behavior_scale->items as $item)
                <tr>
                    <td>{{ $item->short_name}}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                </tr>
            @endforeach
            @include('_tables.end-new-table')
        @endif

        <br/>
        <br/>
        <div style="text-align: center">
            <img src="/storage/report_card_20192020_foot.png" class="img-fluid options-item">
        </div>
        <div class="page-break"></div>
    @endforeach
    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

            Dashmix.helpers(['print']);
            setTimeout('closePrintView()', 3000);

        });

        {{--function closePrintView() {--}}
        {{--    window.location.href = '/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}';--}}
        {{--}--}}

    </script>
@endsection
