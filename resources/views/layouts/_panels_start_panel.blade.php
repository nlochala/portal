{{--
$title = Title of the panel
--}}
<div class="block block-rounded block-bordered block-themed block-fx-pop">
    <div class="block-header bg-{{ env('THEME_CSS') }}">
        <h3 class="block-title">{{ $title }}</h3>
        @if(!isset($with_block) || !$with_block)
            </div>
        @endif