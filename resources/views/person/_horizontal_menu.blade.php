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
    'url' => 'employee/' . $employee->uuid . '/profile',
    'icon' => 'fa fa-address-card',
    'title' => 'Overview',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'employee/' . $employee->uuid . '/contact',
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
    'url' => 'employee/' . $employee->uuid . '/passports_visas',
    'icon' => 'fa fa-passport',
    'title' => 'Passport and Visas',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => "employee/$employee->uuid/id_card",
    'icon' => 'fa fa-id-card',
    'title' => 'Chinese ID Cards',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_submenu_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'employee/' . $employee->uuid . '/official_documents',
    'icon' => 'fa fa-paperclip',
    'title' => 'Official Documents',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'employee/' . $employee->uuid . '/position',
    'icon' => 'fa fa-chalkboard-teacher',
    'title' => 'Employment Details',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('.layouts._horizontal_menu_end')
