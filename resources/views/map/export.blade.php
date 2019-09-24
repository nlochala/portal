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
    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'MAP Roster', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF STUDENTS -->
    @if($classes->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'student_table', 'table_head' => [
        'School Name',
        'Instructor ID',
        'Instructor Last Name',
        'Instructor First Name',
        'User Name',
        'Email Address',
        'Class Name',
        'Student ID',
        'Student Last Name',
        'Student First Name',
        'Student Date Of Birth',
        'Student Gender',
        'Student Grade',
        'Student Ethnic Group Name',
        'Student User Name',
        'Student Email',
        ]])
        @foreach($classes as $class)
            @foreach($class->q1Students as $student)
                <tr>
                    <td>TLC International School</td>
                    <td>{{ $class->primaryEmployee->id ?? '---' }}</td>
                    <td>{{ $class->primaryEmployee->person->family_name ?? '---' }}</td>
                    <td>{{ $class->primaryEmployee->person->given_name ?? '---' }}</td>
                    <td>{{ $class->primaryEmployee->person->email_school ?? '---' }}</td>
                    <td>{{ $class->primaryEmployee->person->email_school ?? '---' }}</td>
                    <td>{{ $class->full_name ?? '---' }}</td>
                    <td>{{ $student->id ?? '---' }}</td>
                    <td>{{ $student->person->family_name ?? '---' }}</td>
                    <td>{{ $student->person->given_name ?? '---' }}</td>
                    <td>{{ $student->person->dob->format('m/d/Y') ?? '---' }}</td>
                    <td>{{ substr($student->person->gender,0,1) ?? '---' }}</td>
                    <td>{{ $student->gradeLevel->short_name ?? '---' }}</td>
                    <td>{{ $student->person->ethnicity->name ?? 'Multi-ethnic' }}</td>
                    <td>{{ $student->username ?? '---' }}</td>
                    <td>{{ $student->username ?? '---' }}</td>
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

    @include('layouts._content_end')
@endsection

@section('js_after')

    <!-- Add Form Validation v.blade -->

    <script type="text/javascript">

        jQuery(document).ready(function () {

            var tablestudent = $('#student_table').DataTable( {
                dom: "Bfrtp",
                select: true,
                paging: true,
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
