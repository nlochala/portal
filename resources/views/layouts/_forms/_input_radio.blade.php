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
        <select class="js-select2 form-control" id="{{ $name }}" name="{{ $name }}" style="width: 100%;">
            <option></option>
            @foreach($array as $value => $name)
                <option value="{{ $value }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
