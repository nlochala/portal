@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'Daily Attendance Report',
    'subtitle' => $date_iso.' - <small><em><a data-toggle="modal" data-target="#modal-block-date" href="#modal-block-date">Change Date</a></em></small>',
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
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 3])
    <a class="block block-link-pop text-center" href="javascript:void(0)">
            <div>
                <div class="font-size-h1 font-w300 text-black">{{ $current_student_count }}</div>
                <div class="font-w600 mt-2 text-uppercase text-muted">Total Enrolled</div>
            </div>
    </a>
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 3])
    <a class="block block-rounded block-link-pop" href="javascript:void(0)">
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
                <!-- Sparkline Container -->
                <span class="js-sparkline" data-type="line"
                      data-points="[{{ $present_stats }}]"
                      data-width="90px"
                      data-height="40px"
                      data-line-color="#3c90df"
                      data-fill-color="transparent"
                      data-spot-color="transparent"
                      data-min-spot-color="transparent"
                      data-max-spot-color="transparent"
                      data-highlight-spot-color="#3c90df"
                      data-highlight-line-color="#3c90df"
                      data-tooltip-suffix="Present"></span>
            </div>
            <div class="ml-3 text-right">
                <p class="text-muted mb-0">
                    Present
                </p>
                <p class="font-size-h3 font-w300 mb-0">
                    {{ $present_count }}
                </p>
            </div>
        </div>
    </a>
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 3])
    <a class="block block-rounded block-link-pop" href="javascript:void(0)">
        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
                <!-- Sparkline Container -->
                <span class="js-sparkline" data-type="line"
                      data-points="[{{ $absent_stats }}]"
                      data-width="90px"
                      data-height="40px"
                      data-line-color="#3c90df"
                      data-fill-color="transparent"
                      data-spot-color="transparent"
                      data-min-spot-color="transparent"
                      data-max-spot-color="transparent"
                      data-highlight-spot-color="#3c90df"
                      data-highlight-line-color="#3c90df"
                      data-tooltip-suffix="Absent"></span>
            </div>
            <div class="ml-3 text-right">
                <p class="text-muted mb-0">
                    Absent
                </p>
                <p class="font-size-h3 font-w300 mb-0">
                    {{ $absent_students->count() }}
                </p>
            </div>
        </div>
    </a>
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

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
                @if($homeroom->attendanceOn($date->format('Y-m-d'))->isEmpty())
                    <td><span class="badge badge-danger"><i class="fa fa-times"></i></span></td>
                    <td>--</td>
                    <td>--</td>
                @else
                    <td><span class="badge badge-success"><i class="fa fa-check"></i></span></td>
                    <td>{{ $homeroom->attendance()->date($date->format('Y-m-d'))->present()->count() }}</td>
                    <td>{{ $homeroom->attendance()->date($date->format('Y-m-d'))->absent()->count() }}</td>
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

    <!-------------------------------- Modal: Change Date Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-date',
        'title' => 'Change Date'
    ])
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New date date field----------------------------->
    @include('layouts._forms._input_date',[
        'name' => 'date',
        'label' => 'Historical Date',
        'format' => 'yyyy-mm-dd',
        'required' => true,
        'selected' => null
    ])
    {{-- MUST ADD form.date.js TO BOTTOM OF PAGE --}}
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Change Date END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-date". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {
            $("#date").datepicker();
            var tableabsent = $('#absent_table').DataTable({
                dom: "frt",
                select: false,
                paging: false,
            });

            var tablehomeroom = $('#homeroom_table').DataTable({
                dom: "",
                select: false,
                paging: false,
            });


        });
    </script>
@endsection
