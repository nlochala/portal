@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Academic Danger',
    'subtitle' => 'Those students with a D or below.',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Academic Danger',
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
    @foreach($grade_array as $name => $students)
        @include('layouts._panels_start_row',['has_uniform_length' => true])
        @include('layouts._panels_start_column', ['size' => 12])
        <!-------------------------------------------------------------------------------->
        <!----------------------------------New Panel ------------------------------------>
        @include('layouts._panels_start_panel', ['title' => $name, 'with_block' => false])
        {{-- START BLOCK OPTIONS panel.block --}}
        @include('layouts._panels_start_content')
        <!-- TABLE OF STUDENTS -->
        @if($students->isEmpty())
            <small><em>Nothing to Display</em></small>
        @else
            @include('_tables.new-table',['id' => 'student_table', 'table_head' => ['ID','Name','Class','Percentage']])
            @foreach($students as $student)
                @php
                    $x = 0;
                @endphp
                @foreach($student->gradeQuarterAverages->where('percentage','<',70)->where('quarter_id',$quarter->id) as $grade)
                    <tr>
                        @if($x === 0)
                            <td>{{ $student->id }}</td>
                            <td>{!! $student->name !!}</td>
                            @php
                                $x = 1;
                            @endphp
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{ $grade->class->fullName() }}</td>
                        <td>{{ $grade->percentage }}% {{ $grade->grade_name }}</td>
                    </tr>
                @endforeach
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
