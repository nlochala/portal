<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Recent Messages', 'with_block' => false])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')

<!-- TABLE OF MESSAGES -->
@if($messages->isEmpty())
    <small><em>Nothing to Display</em></small>
@else
    @include('_tables.new-table',['no_hover' => true, 'id' => 'message_table', 'table_head' => ['','From','Class','Subject']])
    @foreach($messages as $message)
        <tr>
            @if($message->is_read)
                <td><i id="message_{{ $message->id }}_icon" class="si si-envelope-letter"></i></td>
            @else
                <td><i id="message_{{ $message->id }}_icon" class="fa fa-circle" style="color: #0000cc"></i></td>
            @endif
            <td>{{ $message->from->fullName }}</td>
            <td>{{ $message->class->fullName() }}</td>
            <td style="width: 40%">
                <a data-target="#message_{{ $message->id }}" data-toggle="modal" class="MainNavText"
                   id="message_{{ $message->id }}_link"
                   href="#message_{{ $message->id }}">{{ $message->subject }}</a>
            </td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif

<hr/>
@include('_tables.new-table',['no_hover' => true, 'class' => 'table-borderless', 'id' => 'options_table', 'table_head' => ['','','']])
<tr>
    <td>
        <button type="button" class="btn btn-outline-primary mr-1 mb-3" data-toggle="modal"
                data-target="#modal-block-new-message">
            <i class="fa fa-plus"></i> New Message
        </button>
    </td>
    <td>
        <button type="button" class="btn btn-outline-success mr-1 mb-3"
                onclick="window.location.href='/g_message/all'">
            <i class="si si-bubbles"></i> View All Messages
        </button>
    </td>
    <td>
        <button type="button" class="btn btn-outline-success mr-1 mb-3"
                onclick="window.location.href='/g_message/sent'">
            <i class="fa fa-reply"></i> View All Sent Messages
        </button>
    </td>
</tr>
@include('_tables.end-new-table')
<br/>


@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
