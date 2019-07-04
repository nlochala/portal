@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('employee._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $employee->person->preferredName() }}'s
        ID Cards</h1>
    <!--
    panel.row
    panel.column
    panel.panel
    panel.row
    panel.column
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @foreach($id_cards->sortByDesc('is_active') as $id_card)
        @include('person._display_id_card',['id_card' => $id_card])
    @endforeach

    @include('layouts._content_end')
@endsection

@section('js_after')
    <script type="text/javascript">
        jQuery(document).ready(function () {


        });
    </script>
@endsection