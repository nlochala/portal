{{--

$name = text
$label = text
$array = array of data
$required = bool

--}}
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col-sm-8">
        @foreach($array as $value => $description)
            <div class="custom-control custom-radio custom-control-lg mb-1">
                {{
                    Form::radio($name, $value, $selected, [
                        'class' => 'custom-control-input',
                        'id' => $description
                    ])
                }}
                <input type="radio" class="custom-control-input" id="example-rd-custom-lg1" name="example-rd-custom-lg"
                       checked>
                <label class="custom-control-label" for="{{ $description }}">{{ $description }}</label>
            </div>
        @endforeach
    </div>
</div>
