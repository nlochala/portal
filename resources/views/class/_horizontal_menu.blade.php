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
    'url' => 'class/' . $class->uuid,
    'icon' => 'fa fa-arrow-left',
    'title' => 'CLASS DASHBOARD',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/edit_overview',
    'icon' => 'fa fa-address-card',
    'title' => 'Overview',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/edit_enrollment/gradeLevels',
    'icon' => 'fa fa-user-graduate',
    'title' => 'Enrollment',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

{{--@include('layouts._horizontal_menu_item_start')--}}
{{--@include('layouts._horizontal_menu_item', [--}}
{{--    'url' => 'class/' . $class->uuid . '/edit_gradebook',--}}
{{--    'icon' => 'fa fa-address-book',--}}
{{--    'title' => 'Gradebook',--}}
{{--    'badge_number' => null,--}}
{{--    'badge_color' => null--}}
{{--])--}}
{{--@include('layouts._horizontal_menu_item_end')--}}
@include('.layouts._horizontal_menu_end')

