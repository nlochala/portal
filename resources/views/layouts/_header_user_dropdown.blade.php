@if(auth()->user())
<div class="dropdown d-inline-block">
    <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-user d-sm-none"></i>
        <span class="d-none d-sm-inline-block"><img class="img-avatar img-avatar32 img-avatar-thumb" src="{{ auth()->user()->displayThumbnail() }}">  {{ auth()->user()->display_name }} ({{ auth()->user()->username }})</span>
        <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
        <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
            User Options
        </div>
        <div class="p-2">
            <a class="dropdown-item" href="{{ '/employee/' . auth()->user()->person->employee->uuid . '/profile'}}">
                <i class="far fa-fw fa-user mr-1"></i> Profile
            </a>
{{--            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">--}}
{{--                <span><i class="far fa-fw fa-envelope mr-1"></i> Inbox</span>--}}
{{--                <span class="badge badge-primary">3</span>--}}
{{--            </a>--}}
{{--            <a class="dropdown-item" href="javascript:void(0)">--}}
{{--                <i class="far fa-fw fa-file-alt mr-1"></i> Invoices--}}
{{--            </a>--}}
{{--            <div role="separator" class="dropdown-divider"></div>--}}

{{--            <!-- Toggle Side Overlay -->--}}
{{--            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->--}}
{{--            <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">--}}
{{--                <i class="far fa-fw fa-building mr-1"></i> Settings--}}
{{--            </a>--}}
            <!-- END Side Overlay -->

            <div role="separator" class="dropdown-divider"></div>
            <a class="dropdown-item" href="/logout">
                <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
            </a>
        </div>
    </div>
</div>
@endif
