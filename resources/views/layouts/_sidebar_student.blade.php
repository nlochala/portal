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
<!-- END Side Navigation -->
</nav>
<!-- END Sidebar -->
