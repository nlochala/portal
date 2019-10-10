@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $quarter->name }} - Gradebook</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Gradebook', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF GRADES -->
    @if($current_students->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'grades_table', 'table_head' => $table_head, 'class' => 'display nowrap', 'style' => 'width:100%'])
        @foreach($current_students as $student)
            <tr>
                <td>{!! $student->name !!}</td>
                <td>{!! \App\GradeQuarterAverage::displayByClassQuarter($student->gradeQuarterAverages, $class->id, $quarter->id) !!}</td>
                @foreach($assignments as $assignment)
                    @if(isset($excused_array[$assignment->id][$student->id]) && $excused_array[$assignment->id][$student->id])
                        <td><span class="badge badge-secondary"><em>Excused</em></span></td>
                    @elseif(isset($grades_array[$assignment->id][$student->id]) && !empty($grades_array[$assignment->id][$student->id]))
                        <td><strong>{{ $grades_array[$assignment->id][$student->id] }}</strong>  /{{ $assignment->max_points}}</td>
                    @else
                        <td>{{ $grades_array[$assignment->id][$student->id] ?? '--'}}</td>
                    @endif
                @endforeach
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
            var tablegrades = $('#grades_table').DataTable( {
                dom: "Bfrt",
                select: true,
                paging: false,
                scrollX: true,
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
