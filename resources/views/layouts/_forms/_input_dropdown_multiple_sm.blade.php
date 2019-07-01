{{--

$name = text
$label = text
$array = array of data
$required = bool
$class
$selected

--}}
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
        {{ Form::select($name.'[]', $array, $selected, [
        'id' => $name,
        'dusk' => $name,
        'style' => 'width: 100%;',
        'class' => 'js-select2 form-control ' . $class,
        'multiple'
        ]) }}
</div>
