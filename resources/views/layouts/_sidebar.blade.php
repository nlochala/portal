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
@include('layouts._sidebar_heading', ['header' => '----- Manage -----'])
@include('layouts._sidebar_heading', ['header' => 'People'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Employees',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
//       [
//           'title' => 'Dashboard',
//           'uri'   => '/employee/dashboard'
//  ],
        [
            'title' => 'Directory',
            'uri'   => '/employee/index'
        ],
        [
            'title' => 'Positions',
            'uri'   => '/position/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Students',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
 //       [
 //           'title' => 'Summary',
 //           'uri'   => '/student/dashboard'
 //       ],
        [
            'title' => 'Directory',
            'uri'   => '/student/index'
        ],
    ]
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Guardians',
'section_icon' => 'fa fa-users-cog',
'submenu_array' =>
    [
  //      [
  //          'title' => 'Summary',
  //          'uri'   => '/guardian/dashboard'
  //      ],
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
@include('layouts._end_sidebar_menu')
<!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->
