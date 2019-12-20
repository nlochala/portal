@extends('layouts.backend')

@section('content')
    @include('gradebook._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">Behavior Rubric</h1>
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
    @include('layouts._panels_start_panel', ['title' => 'Rubric', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF STANDARDS -->
    @if($standards->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'standards_table', 'table_head' => ['','Satisfactory (S)','Needs Improvement (N)','Unsatisfactory (U)']])
        @foreach($standards as $standard)
            <tr>
                <td bgcolor="#b0e0e6" style="width: 25%">
                    <h4 class="font-w300" style="text-align: center"><br/>{{ $standard->name }}</h4>
                </td>
                @if(!$standard->items->isEmpty())
                    @foreach($standard->items as $item)
                        <td>{{ $item->description }}</td>
                    @endforeach
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
    @include('layouts._panels_end_row')

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
