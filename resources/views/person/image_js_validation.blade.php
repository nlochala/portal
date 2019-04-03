@include('layouts._forms._js_validate_start', ['form_id' => 'profile-form'])
                ignore: [],
                rules: {
                    'profile_image': {
                        required: true
                    }
                },
                messages: {

                }
@include('layouts._forms._js_validate_end')
