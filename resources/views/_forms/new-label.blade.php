
{{--
OPTIONAL
$icon_placement = Is the icon on the right or left of the input field
--}}
@if (!empty($icon_placement))
    @if ($icon_placement == 'left')
        <label class="field prepend-icon">
    @else
        <label class="field append-icon">
    @endif
@else
    <label class="field {{ $class or '' }}">
@endif



