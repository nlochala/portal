<!-- Sidebar -->
<!--
    Sidebar Mini Mode - Display Helper classes

    Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

    Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
    Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
    Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
-->
<nav id="sidebar" aria-label="Main Navigation">

    <!-- Side Header -->
@include('layouts._sidebar_header')

<!-- Side Actions -->
{{--
    @include('layouts._sidebar_buttons')
--}}

@include('layouts._sidebar_menu')

{{--<li class="nav-main-item">--}}
{{--<a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">--}}
{{--<i class="nav-main-link-icon si si-cursor"></i>--}}
{{--<span class="nav-main-link-name">Dashboard</span>--}}
{{--<span class="nav-main-link-badge badge badge-pill badge-success">0</span>--}}
{{--</a>--}}
{{--</li>--}}


@include('layouts._sidebar_heading', ['header' => 'Management'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'People',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
        [
            'title' => 'Employees',
            'uri'   => '/employee/lookup'
        ],
        [
            'title' => 'Students',
            'uri'   => '/student/lookup'
        ],
        [
            'title' => 'Parents',
            'uri'   => '/parent/lookup'
        ],
        [
            'title' => '+ Add New Person',
            'uri'   => '/person/create'
        ]
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Positions',
'section_icon' => 'fa fa-chalkboard-teacher',
'submenu_array' =>
    [
        [
            'title' => 'Summary',
            'uri'   => '/position/summary'
        ],
        [
            'title' => 'Index',
            'uri'   => '/position/index'
        ],
        [
            'title' => '+ Add New Position',
            'uri'   => '/position/create'
        ]
    ]
])
@include('layouts._sidebar_heading', ['header' => 'More'])
@include('layouts._sidebar_menu_submenu_item', [
'uri' => 'examples1/test',
'icon' => 'si si-globe',
'title' => 'Landing'
])
@include('layouts._end_sidebar_menu')
<!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->