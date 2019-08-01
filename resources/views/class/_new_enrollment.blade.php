<!----------------------------------------------------------------------------->
<!-----------------------New quarters[] radio------------------------------------->
@include('layouts._forms._input_checkbox',[
    'name' => 'quarters[]',
    'label' => 'Enroll In Which Quarters',
    'array' => $quarter_dropdown,
    'selected' => null,
    'required' => true,
    'inline' => true
])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->

@include('layouts._forms._heading',['title' => 'ROSTER'])

<select multiple="multiple" id="student-list" name="students[]">
    @foreach($enrollment_lists as $grade => $roster)
        <optgroup label="{{ $grade }}">
            @foreach($roster as $id => $student)
                <option value="{{ $id }}">{{ $student }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>

