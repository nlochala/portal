{{--
$title = Title of the panel
--}}
<div dusk="panel-{{ \Illuminate\Support\Str::slug($title) }}" class="block block-rounded block-bordered block-themed block-fx-pop">
    <div class="block-header bg-{{ env('THEME_CSS') }}">
        <h3 class="block-title">{{ $title }}</h3>
        @if(!isset($with_block) || !$with_block)
            </div>
        @endif