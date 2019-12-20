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
    'url' => 'class/' . $class->uuid.'/'.$quarter->uuid.'/gradebook',
    'icon' => 'si si-graph',
    'title' => 'Gradebook',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/'.$quarter->uuid.'/gradebook/assignments',
    'icon' => 'fa fa-paperclip',
    'title' => 'Assignments',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_submenu_start',[
    'icon' => 'fa fa-hand-holding-heart',
    'title' => 'Behavior'
])
@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/'.$quarter->uuid.'/gradebook/behavior',
    'icon' => 'fa fa-check',
    'title' => 'Student Behavior',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/'.$quarter->uuid.'/gradebook/behavior/rubric',
    'icon' => 'fa fa-table',
    'title' => 'Assessment Rubric',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('layouts._horizontal_menu_submenu_end')

@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_submenu_start',[
    'icon' => 'fa fa-calendar-alt',
    'title' => 'Change Quarters'
])
@foreach(\App\Quarter::current()->get() as $quarter_loop)
    @include('layouts._horizontal_menu_item_start')
    @if($quarter_loop->uuid === $quarter->uuid)
        @include('layouts._horizontal_menu_item', [
            'url' => 'class/' . $class->uuid . '/'.$quarter_loop->uuid.'/gradebook',
            'icon' => 'fa fa-calendar-day',
            'title' => $quarter_loop->name.'- Currently Viewing',
            'badge_number' => null,
            'badge_color' => null
        ])
    @else
        @include('layouts._horizontal_menu_item', [
            'url' => 'class/' . $class->uuid . '/'.$quarter_loop->uuid.'/gradebook',
            'icon' => 'fa fa-calendar-day',
            'title' => $quarter_loop->name,
            'badge_number' => null,
            'badge_color' => null
        ])
    @endif
    @include('layouts._horizontal_menu_item_end')
@endforeach
@include('layouts._horizontal_menu_submenu_end')


@include('layouts._horizontal_menu_item_start')
@include('layouts._horizontal_menu_item', [
    'url' => 'class/' . $class->uuid . '/'.$quarter->uuid.'/gradebook/assignment_type',
    'icon' => 'fa fa-list-ol',
    'title' => 'Assignment Types',
    'badge_number' => null,
    'badge_color' => null
])
@include('layouts._horizontal_menu_item_end')
@include('.layouts._horizontal_menu_end')

