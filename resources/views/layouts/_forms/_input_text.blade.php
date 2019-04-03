{{--

$name = text
$label = text
$placeholder= text
$required = bool

--}}
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-8">
        {!! Form::text($name,null,['class' => 'form-control','id' => $name, 'placeholder' => $placeholder]) !!}
    </div>
</div>
