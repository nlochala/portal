{{--
$uri_parent = examples if the links are examples/*
$section_title = The title of the whole section
$section_icon =  The icon infront of the section title
$submenu_array =
[
    [
        'title' => 'Page 1',
        'uri'   => 'page1'
    ],
    [
        'title' => 'Page 1',
        'uri'   => 'page1'
    ]
]


--}}
<li class="nav-main-item
@foreach($submenu_array as $item)
    {{  request()->is($item['uri']) ? ' open' : '' }}
@endforeach
        ">
    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
        <i class="nav-main-link-icon {{ $section_icon }}"></i>
        <span class="nav-main-link-name">{{ $section_title }}</span>
    </a>
    <ul class="nav-main-submenu">
        @foreach($submenu_array as $item)
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is($item['uri']) ? ' active' : '' }}" href="{{ $item['uri'] }}">
                    <span class="nav-main-link-name">{{ $item['title'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</li>