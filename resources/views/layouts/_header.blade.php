<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">

        <!-- Left Section -->
    @include('layouts._header_leftside')

    <!-- Right Section -->
    <div>
        <!-- User Dropdown -->
        @include('layouts._header_user_dropdown')
        <!-- Notifications Dropdown -->
        @include('layouts._header_notifications')
        <!-- Toggle Side Overlay -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
{{--        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">--}}
{{--            <i class="far fa-fw fa-list-alt"></i>--}}
{{--        </button>--}}
        <!-- END Toggle Side Overlay -->
    </div>
    <!-- END Right Section -->


    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    @can('employee-only')
    @include('layouts._header_search')
    @endcan

    <!-- Header Loader -->
{{--    @include('layouts._header_loader')--}}
</header>
<!-- END Header -->
