@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'New Student Logins - Export',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Student O365 Logins - Export',
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
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Logins', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- TABLE OF LOGINS -->
    @if($students->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'student_table', 'table_head' => ['User Name','First Name','Last Name','Display Name','Job Title','Department','Office Number','Office Phone','Mobile Phone','Fax','Address','City','State or Province','ZIP or Postal Code','Country or Region','TLC Password']])
        @foreach($students as $student)
            <tr>
                <td>{{ $student->username }}</td>
                <td>{{ $student->person->given_name }} @if($student->person->preferred_name !== $student->person->given_name)({{ $student->person->preferred_name }})@endif</td>
                <td>{{ $student->person->family_name }}</td>
                <td>{{ $student->person->family_name }}, {{ $student->person->given_name }} @if($student->person->preferred_name !== $student->person->given_name)({{ $student->person->preferred_name }})@endif</td>
                <td></td>
                <td>student</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $student->password }}</td>
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

            var tablestudent = $('#student_table').DataTable( {
                dom: "Bfrtip",
                pageLength: 50,
                select: true,
                paging: true,
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
