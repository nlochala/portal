@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => $quarter->name.' Behavior Grades',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Behavior Grades',
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
    @include('layouts._panels_start_column', ['size' => 10])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Student Behavior', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF STUDENTS -->
    @if($class->$relationship->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        <!-- START FORM----------------------------------------------------------------------------->

        {!! Form::open(['files' => false, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
        @include('_tables.new-table',['id' => 'student_table', 'table_head' => ['ID','Student','Grade','Comment']])
        @foreach($class->$relationship as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{!! $student->name !!}</td>
                <td>
                    @if(isset($student->behaviorGrades->where('quarter_id',$quarter->id)->first()->grade_scale_item_id))
                        {{ Form::select($student->id.'_dropdown', $grade_scale_dropdown, $student->behaviorGrades->where('quarter_id',$quarter->id)->first()->grade_scale_item_id, [
                            'id' => $student->id.'_dropdown',
                            'class' => 'js-select2 form-control',
                        ]) }}
                    @else
                        {{ Form::select($student->id.'_dropdown', $grade_scale_dropdown, 1, [
                            'id' => $student->id.'_dropdown',
                            'class' => 'js-select2 form-control',
                        ]) }}
                    @endif
                </td>
                <td>
                    @if(isset($student->behaviorGrades->where('quarter_id',$quarter->id)->first()->grade_scale_item_id))
                        {{ Form::textarea($student->id.'_comment', $student->behaviorGrades->where('quarter_id',$quarter->id)->first()->comment, ['rows' =>3, 'cols' => 60]) }}
                    @else
                        {{ Form::textarea($student->id.'_comment', null, ['rows' =>3, 'cols' => 60]) }}
                    @endif
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')

        @include('layouts._forms._form_close')
        <!-- END FORM----------------------------------------------------------------------------->
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
    {!! JsValidator::formRequest('\App\Http\Requests\StoreDefaultRequest','#admin-form') !!}

    <script type="text/javascript">

        // Add Filepond initializer form.js.file
        jQuery(document).ready(function () {


        });
    </script>
@endsection
