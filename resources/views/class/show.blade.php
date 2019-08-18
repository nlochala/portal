@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => $class->fullName(true),
    'subtitle' => $class->getTeachers(true),
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Class Index',
            'page_uri'  => '/class/index'
        ],
        [
            'page_name' => $class->full_name,
            'page_uri'  => '/class/'.$class->uuid
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
    @include('layouts._panels_start_panel', ['title' => 'Overview', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <h4>
        <span class="badge badge-primary"><i class="fa fa-book-open"></i> ID: {{ $class->id }}</span>
        @if($class->course->is_active)
            <span class="badge badge-success"><i
                    class="fa fa-check-circle"></i> ACTIVE - {{ $class->course->year->name }}</span>
        @else
            <span class="badge badge-dark"><i
                    class="fa fa-minus-circle"></i> INACTIVE - {{ $class->course->year->name }}</span>
        @endif
    </h4>

    @include('_tables.new-table',['class' => 'table-borderless', 'id' => 'overview_table', 'table_head' => ['','']])
    <tr>
        <td><strong>Name: </strong>{{ $class->name }}</td>
        <td><strong>Room: </strong>{{ $class->room->buildingNumber }} - {{ $class->room->description }}</td>
    </tr>
    <tr>
        <td><strong>Department: </strong>{{ $class->course->department->name }}</td>
        <td><strong>Primary Teacher: </strong>{!! $class->primaryEmployee->name !!}</td>
    </tr>
    <tr>
        <td><strong>Course: </strong><a href="/course/{{ $class->course->uuid }}">{{ $class->course->name }} ({{ $class->course->short_name }})</a></td>
        <td><strong>Secondary Teacher: </strong>{!! $class->secondaryEmployee->name ?? '--' !!}</td>
    </tr>
    <tr>
        <td><strong>{{ $quarter_name }} Enrollment: </strong>{{ $class->$relationship()->count() }}</td>
        <td><strong>Assistant Teacher: </strong>{!! $class->taEmployee->name !!}</td>
    </tr>

    @include('_tables.end-new-table')

    <button type="button" dusk="btn-modal-block-edit" class="btn btn-outline-danger mr-1 mb-3"
            onclick="window.location.href='/class/{{ $class->uuid }}/edit_overview'">
        <i class="fa fa-pen"></i> Edit Class
    </button>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 7])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => $quarter_name.' Roster', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- TABLE OF STUDENTS -->
    @if($enrollment->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'student-table', 'table_head' => ['#','Preferred Name - Gender','Today\'s Attendance','Date of Birth']])
        @php
        $i = 1;
        @endphp
        @foreach($enrollment as $student)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{!! $student->name !!} - {{ $student->person->gender[0] }}</td>
                <td>Present</td>
                <td>{{ $student->person->dob->format('m-d') }} ({{ $student->person->age }})</td>
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
    <script type="text/javascript">
        jQuery(document).ready(function () {

        });
    </script>
@endsection
