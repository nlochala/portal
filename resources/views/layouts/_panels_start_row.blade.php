{{--
Do you want the length of the panels in the row to
have uniformed length?

$has_uniform_length = true or false
--}}
<div class="row
    @if($has_uniform_length)
        row-deck
    @endif
">