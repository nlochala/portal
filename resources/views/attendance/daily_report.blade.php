@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Daily Attendance Report',
    'subtitle' => now()->isoFormat('dddd, MMMM Do, YYYY'),
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Daily Report',
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

    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 5])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Homerooms Reported', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF CLASSES -->
    @if($homeroom_list->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'homeroom_table', 'table_head' => ['Class','Completed','Present', 'Absent']])
        @foreach($homeroom_list as $homeroom)
            <tr>
                <td><a href="/class/{{ $homeroom->uuid }}">{{ $homeroom->full_name }}</a></td>
                @if($homeroom->todaysAttendance()->isEmpty())
                    <td><span class="badge badge-danger"><i class="fa fa-times"></i></span></td>
                    <td>--</td>
                    <td>--</td>
                @else
                    <td><span class="badge badge-success"><i class="fa fa-check"></i></span></td>
                    <td>{{ $homeroom->attendance()->today()->present()->count() }}</td>
                    <td>{{ $homeroom->attendance()->today()->absent()->count() }}</td>
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
    @include('layouts._panels_start_column', ['size' => 7])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Absent Students', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF ABSENT STUDENTS -->
    @if($absent_students->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'absent_table', 'table_head' => ['ID','Name','Grade Level', 'Reason for Absence']])
        @foreach($absent_students as $a_student)
            <tr>
                <td>{{ $a_student->student->id }}</td>
                <td>{!! $a_student->student->formal_name !!}</td>
                <td>{!! $a_student->student->gradeLevel->name!!} </td>
                <td>{{ $a_student->type->name }}</td>
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
            var tableabsent = $('#absent_table').DataTable( {
                dom: "frt",
                select: false,
                paging: false,
            });

            var tablehomeroom = $('#homeroom_table').DataTable( {
                dom: "",
                select: false,
                paging: false,
            });


        });
    </script>
@endsection
