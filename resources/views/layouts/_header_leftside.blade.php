<!-- Left Section -->
<div>
    <!-- Toggle Sidebar -->
    <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
    <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
        <i class="fa fa-fw fa-bars"></i>
    </button>
    <!-- END Toggle Sidebar -->

    <!-- Open Search Section -->
    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
    @can('employee-only')
    <button type="button" class="btn btn-dual" id="header_search_button" data-toggle="layout" data-action="header_search_on">
        <i class="fa fa-fw fa-search"></i> <span class="ml-1 d-none d-sm-inline-block">Search</span>
    </button>
    @endcan
    <!-- END Open Search Section -->
</div>
<!-- END Left Section -->
