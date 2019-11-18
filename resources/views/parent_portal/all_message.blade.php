@extends('layouts.backend_guardian')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'All Messages',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Dashboard',
            'page_uri'  => '/g_guardian/guardian'
        ],
        [
            'page_name' => 'All Messages',
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
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Messages', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF MESSAGES -->
    @if($messages->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else

        @include('_tables.new-table',['no_hover' => true, 'id' => 'message_table', 'table_head' => ['','To','Date Sent','Class','Subject']])
        @foreach($messages as $message)
            <tr>
                <td><i id="message_{{ $message->id }}_icon" class="si si-envelope-letter"></i></td>
                <td>{{ $message->to->fullName }}</td>
                <td>{{ $message->createdAt }}</td>
                <td>{{ $message->class->fullName() }}</td>
                <td>
                    <a data-target="#message_{{ $message->id }}" data-toggle="modal" class="MainNavText"
                       id="message_{{ $message->id }}_link"
                       href="#message_{{ $message->id }}">{{ $message->subject }}</a>
                </td>
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
    @foreach($messages as $message)

        <!-------------------------------- Modal: TITLE Start------------------------------------------->
        @include('layouts._modal_panel_start',[
            'id' => 'message_'.$message->id,
            'title' => $message->subject
        ])

        <strong>From:</strong> {{ $message->from->fullName }}<br />
        <strong>To:</strong> {{ $message->to->fullName }}<br />
        <strong>Send On:</strong> {{ $message->created_at }}<br />
        <hr />
        <strong>Subject:</strong><br />
        {{ $message->subject }}<br /><br />
        <strong>Message:</strong> <br />
        {!! $message->body  !!} <br />
        <br /><br />
        @include('layouts._modal_panel_end')
        <!-------------------------------- Modal: TITLE END------------------------------------------->
        <!------   data-toggle="modal" data-target="#modal-block-ID". ----->
    @endforeach
@endsection

@section('js_after')

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

        });
    </script>
@endsection
