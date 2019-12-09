<!-------------------------------- Modal: Today\'s Attendance Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-attendance',
    'title' => 'UPDATE: Today\'s Attendance'
])
<!-- START FORM----------------------------------------------------------------------------->
{!! Form::open(['files' => false, 'id' => 'admin-form','url' => 'class/'.$class->uuid.'/update_attendance'])!!}

<!-- TABLE OF STUDENTS -->
@if($enrollment->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['id' => 'student-table', 'table_head' => ['#','Preferred Name - Gender','Today\'s Attendance']])
    @php
        $i = 1
    @endphp
    @foreach($enrollment as $student)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{!! $student->name !!} - {{ $student->person->gender[0] }}</td>
            <td>
                @if($student->todaysClassAttendance()->where('class_id','=',$class->id)->first())
                    {{ Form::select($student->id, $type_dropdown,$student->todaysClassAttendance()->where('class_id','=',$class->id)->first()->type->id , [
                    'id' => $student->id,
                    'class' => 'js-select2 form-control',
                    ]) }}
                @else
                    {{ Form::select($student->id, $type_dropdown,1, [
                    'id' => $student->id,
                    'class' => 'js-select2 form-control',
                    ]) }}
                @endif
            </td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif
@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->
@include('layouts._modal_panel_end')
<!-------------------------------- Modal: Today\'s Attendance END------------------------------------------->
<!------   data-toggle="modal" data-target="#modal-block-attendance". ----->
