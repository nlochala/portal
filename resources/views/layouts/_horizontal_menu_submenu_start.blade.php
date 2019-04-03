@include('layouts._horizontal_menu_item_start')
<a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
    <i class="nav-main-link-icon {{ $icon }}"></i>
    <span class="nav-main-link-name">{{ $title }}</span>
</a>
<ul class="nav-main-submenu">