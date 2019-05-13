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
                @if($selected == $value)
                    {{
                        Form::radio($name, $value, true, [
                            'class' => 'custom-control-input',
                            'id' => $description
                        ])
                    }}
                @else
                    {{
                        Form::radio($name, $value, false, [
                            'class' => 'custom-control-input',
                            'id' => $description
                        ])
                    }}
                @endif
                <label class="custom-control-label" dusk="{{ \Illuminate\Support\Str::slug($description) }}" for="{{ $description }}">{{ $description }}</label>
            </div>
        @endforeach
    </div>
</div>
