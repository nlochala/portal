{{--

$name = text
$label = text
$placeholder= text
$required = bool

--}}
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
        {!! Form::text($name,null,['dusk' => $name, 'class' => 'form-control','id' => $name, 'placeholder' => $placeholder]) !!}
</div>
