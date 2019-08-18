@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('layouts._breadcrumbs', [
    'title' => 'GUARDIAN: '.$guardian->person->preferred_name.' '.$guardian->person->family_name,
    'breadcrumbs' => [
        [
            'page_name' => 'Portal',
            'page_uri'  => '/',
        ],
        [
            'page_name' => 'Guardian Dashboard',
            'page_uri'  => request()->getRequestUri(),
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
    @include('layouts._panels_start_column', ['size' => 8])

    @include('guardian._info_panel_large')

    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 4])

    @include('person._profile_image', ['person' => $guardian->person])

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @if ($guardian->family)
        @include('layouts._panels_start_row',['has_uniform_length' => false])
        @include('layouts._panels_start_column', ['size' => 8])

        @include('family._student_table', ['family' => $guardian->family])

        @include('layouts._panels_end_column')
        @include('layouts._panels_start_column', ['size' => 4])

        @include('family._guardian_table', ['family' => $guardian->family, 'exclude' => $guardian->id])

        @include('layouts._panels_end_column')
        @include('layouts._panels_end_row')
    @else
        <hr />
        <h2 class="font-w400" style="text-align: center">{{ $guardian->person->fullName()}} does not have a family.<br />
            @can('guardian.update.biographical')
        <button style="width: 25%" class="btn btn-hero-lg btn-hero-primary"
                onclick="location.href='/guardian/{{ $guardian->uuid }}/new_family'"
                data-toggle="click-ripple">Add To Family</button></h2>
        <hr />
        @endcan
    @endif

    @if ($guardian->person->user)
        @include('layouts._panels_start_row',['has_uniform_length' => false])
        @include('layouts._panels_start_column', ['size' => 3])
        @include('user._ad_information', ['user' => $guardian->person->user])
        @include('layouts._panels_end_column')
        @include('layouts._panels_start_column', ['size' => 9])
        @include('user._ad_groups', ['user' => $guardian->person->user])
        @include('layouts._panels_end_column')
        @include('layouts._panels_end_row')
    @endif

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
