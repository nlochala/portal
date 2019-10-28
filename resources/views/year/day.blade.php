@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'School Calendar',
    'subtitle' => $year->name.' - <small><em><a data-toggle="modal" data-target="#modal-block-date" href="#modal-block-date">Change Year</a></em></small>',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Calendar of Days',
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
    @foreach($quarters as $quarter)
        @include('layouts._panels_start_column', ['size' => 3])
        <a class="block block-link-pop text-center" href="javascript:void(0)">
            <div>
                <div class="font-size-h1 font-w300 text-black">{{ $quarter->instructional_days}}</div>
                <div class="font-w600 mt-2 text-uppercase text-muted">{{ $quarter->name }} Instructional Days</div>
            </div>
        </a>
        @include('layouts._panels_end_column')
    @endforeach
    @include('layouts._panels_end_row')

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 8])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'School Calendar', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <div id='calendar'></div>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')
    <!-------------------------------- Modal: Select Year Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-date',
        'title' => 'Select Year'
    ])

    <ul>
        @foreach($years as $year)
            <li><a href="/holiday/{{ $year->uuid }}/index">{{ $year->name }}</a></li>
        @endforeach
    </ul>

    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Select Year END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-date". ----->
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['bootstrap', 'interaction', 'dayGrid'],
                header: {
                    left: 'prev,next, today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                bootstrapFontAwesome: {
                    close: 'fa-times',
                    prev: 'fa-chevron-left',
                    next: 'fa-chevron-right',
                    prevYear: 'fa-angle-double-left',
                    nextYear: 'fa-angle-double-right'
                },
                themeSystem: 'bootstrap',
                weekends: false,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                        @foreach($quarters as $quarter)
                    {
                        title: 'Beginning of {{ $quarter->name }}',
                        start: '{{ $quarter->start_date }}',
                        end: '{{ $quarter->start_date }}',
                        color: "purple",
                    },
                    {
                        title: 'End of {{ $quarter->name }}',
                        start: '{{ $quarter->end_date }}',
                        end: '{{ $quarter->end_date }}',
                        color: "purple",
                    },
                        @foreach($quarter->holidays as $holiday)
                    {
                        title: 'HOLIDAY: {{ $holiday->name }}',
                        start: '{{ $holiday->start_date }}',
                        end: '{{ \Carbon\Carbon::parse($holiday->end_date)->addDay()->format('Y-m-d') }}',
                        color: "yellow",
                        textColor: "black",
                    },
                    {
                        start: '{{ $holiday->start_date }}',
                        end: '{{ \Carbon\Carbon::parse($holiday->end_date)->addDay()->format('Y-m-d') }}',
                        rendering: "background",
                        color: "yellow"
                    },
                    @endforeach
                    @endforeach
                ]
            });

            calendar.render();
        });


        // Add Filepond initializer form.js.file
        jQuery(document).ready(function () {


        });
    </script>
@endsection
