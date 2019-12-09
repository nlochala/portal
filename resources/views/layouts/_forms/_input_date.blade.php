{{--

$name = text
$label = text
$format = mm-dd-yyyy (example)
$required = bool

--}}
@if(!isset($selected))
    @php
    $selected = null
    @endphp
@endif

<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-8">
        {{ Form::text($name, $selected, [
        'id' => $name,
        'class' => 'js-datepicker form-control',
        'data-week-start' => '1',
        'data-autoclose' => 'true',
        'data-today-highlight' => 'true',
        'data-date-format' => $format,
        'placeholder' => $format
        ]) }}
    </div>
</div>
