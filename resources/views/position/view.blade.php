@extends('layouts.backend')

@section('content')
    @include('layouts._breadcrumbs', [
    'title' => 'Employee Positions - Index',
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'Position Index',
            'page_uri'  => '/position/index'
        ],
        [
            'page_name' => 'Position - '.$position->name,
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
    @include('layouts._panels_start_panel', ['title' => $position->name, 'with_block' => true])
    <div class="block-options">
        <button type="button" class="btn btn-hero-sm btn-hero-light" data-toggle="tooltip" title="Edit"
                onclick="window.location.href='/position/{{ $position->uuid }}/edit'">
            <i class="fa fa-pen"></i> Edit
        </button>
        <button type="button" class="btn btn-hero-sm  btn-hero-danger" data-toggle="tooltip" title="Archive"
                onclick="window.location.href='/position/{{ $position->uuid }}/archive'">
            <i class="fa fa-times"></i> Archive
        </button>
    </div>
    </div>
    {{-- END BLOCK OPTIONS --}}
    @include('layouts._panels_start_content')

    @include('_tables.new-table',['style' => 'width: 75%', 'class' => 'table-borderless', 'id' => $position->id.'_table', 'table_head' => ['','']])
    <tr>
        <td><strong>Position Title:</strong></td>
        <td>{{ $position->name}}</td>
    </tr>
    <tr>
        <td><strong>Type:</strong></td>
        <td>{{ $position->type->name}}</td>
    </tr>
    <tr>
        <td><strong>Area of Responsibility:</strong></td>
        <td>{{ $position->school->name}}</td>
    </tr>
    <tr>
        <td><strong>Supervising Position:</strong></td>
        <td>{{ $position->supervisor->name}}</td>
    </tr>
    <tr>
        <td><strong>Stipend:</strong></td>
        <td>{{ $position->stipend }}</td>
    </tr>
    @include('_tables.end-new-table')
    <strong>Position Description</strong>
    <p>{!! $position->description !!}</p>

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
@endsection

@section('js_after')
    <script type="text/javascript">
        jQuery(document).ready(function () {

        });
    </script>
@endsection