{{--
$uri_parent = examples if the links are examples/*
$section_title = The title of the whole section
$section_icon =  The icon infront of the section title
$submenu_array =
[
    [
        'title' => 'Page 1',
        'uri'   => 'page1'
        'guard' => 'positions.show.positions'
    ],
    [
        'title' => 'Page 1',
        'uri'   => 'page1'
    ]
]


--}}
@if(!empty($submenu_array))
    <li class="nav-main-item
@foreach($submenu_array as $item)
    @if(\App\Helpers\ViewHelpers::isUri($item['uri'], false))
        open
@endif
    @endforeach
        ">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"

           @if(\App\Helpers\ViewHelpers::isUri($item['uri'], false))
           aria-expanded="true"
           @else
           aria-expanded="false"
           @endif
           href="#">
            <i class="nav-main-link-icon {{ $section_icon }}"></i>
            <span class="nav-main-link-name">{{ $section_title }}</span>
        </a>
        <ul class="nav-main-submenu">
            @foreach($submenu_array as $item)
                @if(isset($item['guard']) && !auth()->user()->can($item['guard']))
                    @continue
                @endif
                <li class="nav-main-item">
                    <a class="nav-main-link
        @if(request()->getRequestUri() == $item['uri'])
                        active
@endif
                        " href="{{ $item['uri'] }}">
                        <span class="nav-main-link-name">{{ $item['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
