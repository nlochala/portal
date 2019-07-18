@include('layouts._horizontal_menu_start', ['title' => 'Profile Menu'])
@include('layouts._horizontal_menu_item_start')

<!--

Single Item
h.item

Dropdown With Single Items
h.submenu
h.item
h.item

Dropdown With Multiple Submenus
h.submenu
h.submenu
h.item
h.item

-->
@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid,
    'icon' => 'fa fa-arrow-left',
    'title' => 'STUDENT DASHBOARD',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid . '/profile',
    'icon' => 'fa fa-address-card',
    'title' => 'Overview',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid . '/contact',
    'icon' => 'fa fa-warehouse',
    'title' => 'Contact Information',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_submenu_start',[
    'icon' => 'fa fa-globe',
    'title' => 'Government Documents'
])
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid . '/passports_visas',
    'icon' => 'fa fa-passport',
    'title' => 'Passport and Visas',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => "student/$student->uuid/id_card",
    'icon' => 'fa fa-id-card',
    'title' => 'Chinese ID Cards',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_submenu_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid . '/official_documents',
    'icon' => 'fa fa-paperclip',
    'title' => 'Official Documents',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_submenu_start',[
    'icon' => 'fa fa-chalkboard-teacher',
    'title' => 'Academics'
])
@include('layouts._horizontal_menu_item', [
    'url' => 'student/' . $student->uuid . '/academics/overview',
    'icon' => 'fa fa-list',
    'title' => 'Overview',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
{{--@include('layouts._horizontal_menu_item_start')--}}
{{--@include('layouts._horizontal_menu_item', [--}}
{{--    'url' => "student/$student->uuid/transcripts",--}}
{{--    'icon' => 'fa fa-columns',--}}
{{--    'title' => 'Transcripts',--}}
{{--    'badge_number' => null,--}}
{{--    'badge_color' => null--}}
{{--])--}}
{{--@include('layouts._horizontal_menu_item_end')--}}
@include('layouts._horizontal_menu_submenu_end')
@include('layouts._horizontal_menu_item_start')
@if($student->family_id === null)
    @include('layouts._horizontal_menu_item', [
        'url' => 'student/' . $student->uuid . '/new_family',
        'icon' => 'fa fa-users',
        'title' => 'Family',
        'badge_number' => null,
        'badge_color' => null
    ])
@else
    @include('layouts._horizontal_menu_item', [
        'url' => 'family/' . $student->family->uuid,
        'icon' => 'fa fa-users',
        'title' => 'Family',
        'badge_number' => null,
        'badge_color' => null
    ])
@endif
@include('.layouts._horizontal_menu_end')

