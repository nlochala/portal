{{--
$title = Title of the panel
$size = size of the column
--}}
@include('layouts._panels_start_column', ['size' => $size])
<div class="block block-rounded block-bordered block-themed">
    <div class="block-header bg-{{ env('THEME_CSS') }}">
        <h3 class="block-title">{{ $title }}</h3>