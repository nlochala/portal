{{--

$name = text
$label = text
$placeholder= text
--}}
<div class="form-group row">
    <label class="col-sm-4 col-form-label" for="{{ $name }}">{{ $label }}
    </label>
    <div class="col-sm-8">
        {!! Form::text($name,null,['class' => 'form-control', 'readonly' => true, 'id' => $name, 'placeholder' => $placeholder]) !!}
    </div>
</div>
