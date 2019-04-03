{{--

$name = text
$label = text
$array = array of data
$required = bool
$selected

--}}
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-8">
        @foreach($array as $value => $description)
            <div class="custom-control custom-radio custom-control-inline">
                {{ Form::radio($name, $value, $selected, [
                'class' => 'custom-control-input',
                'id' => $description
                ]) }}
                <label class="custom-control-label" for="{{ $description }}">{{ $description }}</label>
            </div>
        @endforeach
    </div>
</div>
