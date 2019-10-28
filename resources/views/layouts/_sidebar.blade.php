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
@include('layouts._sidebar_menu_submenu_item', [
'uri' => '/',
'icon' => 'si si-globe',
'title' => 'Home'
])
@include('layouts._sidebar_menu_submenu_item', [
'uri' => '/videos/channel/how-to',
'icon' => 'si si-question',
'title' => 'How-To Videos'
])
@include('layouts._sidebar_heading', ['header' => 'People'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Employees',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
        [
            'title' => 'Directory',
            'uri'   => '/employee/index'
        ],
        [
            'title' => 'Positions',
            'uri'   => '/position/index',
            'guard' => 'positions.show.positions'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Students',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
        [
            'title' => 'Directory',
            'uri'   => '/student/index'
        ],
        [
            'title' => 'Office 365 Logins',
            'uri'   => '/student/logins',
            'guard' => 'students.show.full_profile'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Guardians',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
        [
            'title' => 'Directory',
            'uri'   => '/guardian/index'
        ],
    ]
])
@include('layouts._sidebar_heading', ['header' => 'Calendar'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'School Year',
'section_icon' => 'fa fa-calendar-alt',
'submenu_array' =>
    [
        [
            'title' => 'Years',
            'uri'   => '/year/index'
        ],
        [
            'title' => 'Quarters',
            'uri'   => '/quarter/index'
        ],
        [
            'title' => 'Days',
            'uri'   => '/day/'.App\Year::currentYear()->uuid.'/index'
        ],
        [
            'title' => 'Holidays',
            'uri'   => '/holiday/'.App\Year::currentYear()->uuid.'/index'
        ],
    ]
])
@include('layouts._sidebar_heading', ['header' => 'Academics'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Courses',
'section_icon' => 'fa fa-book-reader',
'submenu_array' =>
    [
 //       [
 //           'title' => 'Dashboard',
 //           'uri'   => '/course/dashboard'
 //       ],
        [
            'title' => 'Index',
            'uri'   => '/course/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Classes',
'section_icon' => 'fa fa-chalkboard-teacher',
'submenu_array' =>
    [
 //       [
 //           'title' => 'Dashboard',
 //           'uri'   => '/course/dashboard'
 //       ],
        [
            'title' => 'Index',
            'uri'   => '/class/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Attendance',
'section_icon' => 'fa fa-user-check',
'submenu_array' =>
    [
        [
            'title' => 'Daily Report',
            'uri'   => '/attendance/daily_report'
        ],
//        [
//            'title' => 'Modify Attendance',
//            'uri'   => '/attendance/modify'
//        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Grade Levels',
'section_icon' => 'fa fa-user-graduate',
'submenu_array' =>
    [
        [
            'title' => 'Index',
            'uri'   => '/grade_level/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Grade Scales',
'section_icon' => 'fa fa-balance-scale',
'submenu_array' =>
    [
        [
            'title' => 'Index',
            'uri'   => '/grade_scale/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Departments',
'section_icon' => 'fa fa-building',
'submenu_array' =>
    [
        [
            'title' => 'Index',
            'uri'   => '/department/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Testing',
'section_icon' => 'fa fa-laptop',
'submenu_array' =>
    [
        [
            'title' => 'MAP Roster Export',
            'uri'   => '/map/export'
        ],
    ]
])
@include('layouts._sidebar_heading', ['header' => 'Facilities'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Room Assignments',
'section_icon' => 'fa fa-school',
'submenu_array' =>
    [
        [
            'title' => 'Rooms',
            'uri'   => '/room/index'
        ],
        [
            'title' => 'Buildings',
            'uri'   => '/building/index'
        ],
        [
            'title' => 'Room Types',
            'uri'   => '/room_type/index'
        ],
    ]
])
@can('permissions')
@include('layouts._sidebar_heading', ['header' => 'Portal Administration'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Permissions',
'section_icon' => 'fa fa-user-lock',
'submenu_array' =>
    [
//        [
//            'title' => 'Users',
//            'uri'   => '/user/index'
//        ],
        [
            'title' => 'Roles',
            'uri'   => '/role/index'
        ],
        [
            'title' => 'Permissions',
            'uri'   => '/permission/index'
        ],
    ]
])
@include('layouts._end_sidebar_menu')
@endcan
<!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->
