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
@php

    $guardian = auth()->user()->person->guardian;
    $student_menu_array = [];
    $guardian_menu_array = [];

    if ($guardian->family) {
    $students = $guardian->family->students;
    $guardians = $guardian->family->guardians;

    foreach($students as $s) {
    $student_menu_array[] = [
    'title' => $s->fullName,
    'uri'   => '/g_student/student/'.$s->uuid,
    'guard' => 'guardian-only',
    ];
    }

    foreach($guardians as $g) {
    $guardian_menu_array[] = [
    'title' => $g->fullName,
    'uri'   => '/g_guardian/guardian/'.$g->uuid,
    'guard' => 'guardian-only',
    ];
    }
    }
@endphp

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
@include('layouts._sidebar_heading', ['header' => 'PEOPLE'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'My Students',
'section_icon' => 'fa fa-users-cog',
'submenu_array' => $student_menu_array,
])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Guardians',
'section_icon' => 'fa fa-users-cog',
'submenu_array' => $guardian_menu_array,
])
@include('layouts._sidebar_heading', ['header' => 'COMMUNICATION'])
@include('layouts._sidebar_menu_nested_submenu', [
'section_title' => 'Teacher Messages',
'section_icon' => 'si si-bubble',
'submenu_array' =>
    [
        [
            'title' => 'New Message',
            'uri' => '/g_message/new',
            'guard' => 'guardian-only',
        ],
        [
            'title' => 'All Messages',
            'uri' => '/g_message/all',
            'guard' => 'guardian-only',
        ],
        [
            'title' => 'Sent Messages',
            'uri' => '/g_message/sent',
            'guard' => 'guardian-only',
        ],
    ]
])
<!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->
