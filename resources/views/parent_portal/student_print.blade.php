@extends('layouts.backend_guardian')

@section('content')
    @include('layouts._content_start')
    <h1 class="flex-sm-fill font-size-h1 font-w400 mt-2 mb-0 mb-sm-2">
        {{ $student->person->family_name }}
        , {{ $student->person->given_name }} @if($student->person->preferred_name !== $student->person->given_name)
            ({{ $student->person->preferred_name }})@endif - Grade Report
        <br/>
        <em><small><small>{{ $class->fullName(false) }}
                    | {{ $class->primaryEmployee->person->fullName() }}</small></small></em>
    </h1>
    <br/>
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
    <div style="text-align: center">
        <h3>{{ $quarter->year->name }} Summary</h3>
    </div>
    <!-- TABLE OF TYPES -->
    @if($assignment_types->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'types_table', 'style' => 'border: 1px solid lightgray', 'table_head' => ['Type and Weight', 'Quarter 1','Quarter 2', 'Quarter 3', 'Quarter 4']])
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
    <br/>
    <br/>
    <br/>
    <div style="text-align: center">
        <h3>Quarter {{ preg_replace('/Q/','',$quarter->name) }} Details</h3>
    </div>
    @foreach($assignment_types as $type)
        <h4>{{ $type->name }}</h4>
        <!-- TABLE OF ASSIGNMENTS -->
        @if($type->assignments()->where('quarter_id',$quarter->id)->get()->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['no_hover' => true, 'style' => 'border: 1px solid lightgray', 'id' => 'assignment_id', 'table_head' => ['Name','Date Assigned','Points Earned', 'Percentage', 'Date Turned In']])
            @foreach($type->assignments as $assignment)
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
        <br/>
    @endforeach
    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        {{--jQuery(function(){  });--}}
        {{--window.location.replace('/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}');--}}

        jQuery(document).ready(function () {
            Dashmix.helpers(['print']);
            setTimeout('closePrintView()', 3000);

        });

        function closePrintView() {
            window.location.href = '/g_student/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}';
        }

    </script>
@endsection
