<div class="dropdown d-inline-block">
    <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bell"></i>
        <span class="badge badge-secondary badge-pill">5</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
        <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
            My Notifications
        </div>
        <ul class="nav-items my-2" id="layout-notification-dropdown">
            @foreach($notifications as $notification)
                <li>
                    <a class="text-dark media py-2" href="{!!$notification->data['uri'] !!}">
                        <div class="mx-3">
                            {!! $notification->data['icon'] !!}
                        </div>
                        <div class="media-body font-size-sm pr-2">
                            <div class="font-w600">{{ $notification->data['name'] }}</div>
                            <div class="text-muted font-italic">{{ $notification->data['created_at'] }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
            <li>
                <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mx-3">
                        <i class="fa fa-fw fa-user-plus text-info"></i>
                    </div>
                    <div class="media-body font-size-sm pr-2">
                        <div class="font-w600">New Subscriber was added! You now have 2580!</div>
                        <div class="text-muted font-italic">10 min ago</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mx-3">
                        <i class="fa fa-fw fa-times-circle text-danger"></i>
                    </div>
                    <div class="media-body font-size-sm pr-2">
                        <div class="font-w600">Server backup failed to complete!</div>
                        <div class="text-muted font-italic">30 min ago</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mx-3">
                        <i class="fa fa-fw fa-exclamation-circle text-warning"></i>
                    </div>
                    <div class="media-body font-size-sm pr-2">
                        <div class="font-w600">You are running out of space. Please consider upgrading your plan.</div>
                        <div class="text-muted font-italic">1 hour ago</div>
                    </div>
                </a>
            </li>
            <li>
                <a class="text-dark media py-2" href="javascript:void(0)">
                    <div class="mx-3">
                        <i class="fa fa-fw fa-plus-circle text-primary"></i>
                    </div>
                    <div class="media-body font-size-sm pr-2">
                        <div class="font-w600">New Sale! + $30</div>
                        <div class="text-muted font-italic">2 hours ago</div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="p-2 border-top">
            <a class="btn btn-light btn-block text-center" href="{{ url('/notifications/index') }}">
                <i class="fa fa-fw fa-eye mr-1"></i> View All
            </a>
        </div>
    </div>
</div>
