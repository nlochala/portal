<div class="dropdown d-inline-block">
    <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bell"></i>
        <span class="badge badge-secondary badge-pill"
              id="layout-notification-badge">{{ $notifications->count() }}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
         aria-labelledby="page-header-notifications-dropdown">
        <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
            My Notifications
        </div>
        <ul class="nav-items my-2" id="layout-notification-dropdown">
            @if($notifications->count() === 0)
                <div class="mx-3">
                    <small>You have no new notifications at this time. :)</small>
                </div>
            @endif
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
        </ul>
        {{--        <div class="p-2 border-top">--}}
        {{--            <a class="btn btn-light btn-block text-center" href="{{ url('/notifications/index') }}">--}}
        {{--                <i class="fa fa-fw fa-eye mr-1"></i> View All--}}
        {{--            </a>--}}
        {{--        </div>--}}
    </div>
</div>
