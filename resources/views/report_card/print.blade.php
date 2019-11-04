@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
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
    @foreach($students as $student)
    <div style="text-align: center">
        <img src="/storage/report_card_20192020_head.png" class="img-fluid options-item">
    </div>


















    <div style="text-align: center">
        <img src="/storage/report_card_20192020_foot.png" class="img-fluid options-item">
    </div>
        <div class="page-break"></div>
    @endforeach
    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        // Add Filepond initializer form.js.file

        jQuery(document).ready(function () {

            Dashmix.helpers(['print']);
            setTimeout('closePrintView()', 3000);

        });

        {{--function closePrintView() {--}}
        {{--    window.location.href = '/report/grades/{{ $class->uuid }}/{{ $quarter->uuid }}/{{ $student->uuid }}';--}}
        {{--}--}}

    </script>
@endsection
