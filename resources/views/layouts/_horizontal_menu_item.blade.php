{{--

url
icon
title
badge_number
badge_color

--}}

<a class="nav-main-link
    @if(request()->is($url))
        active
    @endif
        " href="/{{ $url }}">
    <i class="nav-main-link-icon {{ $icon }}"></i>
    <span class="nav-main-link-name">{{ $title }}</span>
    @if($badge_number)
        <span class="nav-main-link-badge badge badge-pill badge-{{ $badge_color }}">{{ $badge_number }}</span>
    @endif
</a>

