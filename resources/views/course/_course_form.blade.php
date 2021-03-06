<!----------------------------------------------------------------------------->
<!---------------------------New year_id dropdown----------------------------->
@if(isset($type) && $type == 'update')
    @include('layouts._forms._input_radio',[
        'name' => 'year_id',
        'label' => 'School Year',
        'array' => $year_dropdown,
        'selected' => null,
        'required' => true
    ])
@else
    @include('layouts._forms._input_radio',[
        'name' => 'year_id',
        'label' => 'School Year',
        'array' => $year_dropdown,
        'selected' => env('SCHOOL_YEAR_ID'),
        'required' => true
    ])
@endif
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New department_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'department_id',
    'label' => 'Department',
    'array' => $departments,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New grade_levels[] dropdown----------------------------->
@include('layouts._forms._input_dropdown_multiple',[
    'name' => 'grade_levels',
    'label' => 'Grade Levels',
    'array' => $grade_level_dropdown,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New short_name text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'short_name',
    'label' => 'Abbreviation',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New name text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'name',
    'label' => 'Name',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New description text field----------------------------->
@include('layouts._forms._input_text',[
    'name' => 'description',
    'label' => 'Description',
    'placeholder' => '',
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New course_type_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'course_type_id',
    'label' => 'Course Type',
    'array' => $course_types,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New grade_scale_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'grade_scale_id',
    'label' => 'Grade Scale',
    'array' => $grade_scales,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
<!---------------------------New course_transcript_id dropdown----------------------------->
@include('layouts._forms._input_dropdown',[
    'name' => 'course_transcript_type_id',
    'label' => 'Transcript Type',
    'array' => $transcript_types,
    'class' => null,
    'selected' => null,
    'required' => true
  ])
<!----------------------------------------------------------------------------->
<!----------------------------------------------------------------------------->
