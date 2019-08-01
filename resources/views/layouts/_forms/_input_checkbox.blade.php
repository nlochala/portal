{{--

$name = text
$label = text
$array = array of data
$required = bool

--}}
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-8">
        @foreach($array as $value => $description)
            @if(isset($inline) && $inline === true)
                <div class="custom-control-lg custom-control custom-checkbox custom-control-inline mb-1">
            @else
                <div class="custom-control custom-checkbox custom-control-lg mb-1">
            @endif
                @if($selected == $value)
                    {{
                        Form::checkbox($name, $value, true, [
                            'class' => 'custom-control-input',
                            'id' => $description
                        ])
                    }}
                @else
                    {{
                        Form::checkbox($name, $value, false, [
                            'class' => 'custom-control-input',
                            'id' => $description
                        ])
                    }}
                @endif
                <label class="custom-control-label" dusk="radio-{{ \Illuminate\Support\Str::slug($description) }}" for="{{ $description }}">{{ $description }}</label>
            </div>
        @endforeach
    </div>
</div>
