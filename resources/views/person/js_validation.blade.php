@include('layouts._forms._js_validate_start')
jQuery('#admin-form').validate({
                ignore: [],
                rules: {
                    'type': {
                        required: true
                    },
                     'title': {
                        required: true
                     },
                    'given_name': {
                        required: true
                    },
                    'family_name': {
                        required: true
                    },
                    'gender': {
                        required: true
                    },
                    'dob': {
                        required: true
                    },
                    'email_primary': {
                        required: true,
                        email: true
                    },
                    'email_secondary': {
                        email: true
                    },
                    'country_of_birth_id': {
                        required: true,
                    },
                    'language_primary_id': {
                        required: true,
                    },
                    'ethnicity_id': {
                        required: true
                    }
                },
                messages: {

                }
});
@include('layouts._forms._js_validate_end')
