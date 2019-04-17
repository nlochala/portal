@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('person._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $employee->person->preferredName() }}'s
        Passports and Visas</h1>
    <!--
    panel.row
    panel.column
    panel.panel
    panel.row
    panel.column
    panel.panel

    ---------------
    panel.row
    panel.column
    panel.panel
    panel.column
    panel.panel

    |--------------||--------------|
    |              ||              |
    |--------------||--------------|

-->
    @foreach($passports as $passport)
        @include('person._display_passport', ['passport' => $passport])
    @endforeach

    @include('layouts._content_end')
@endsection

@section('js_after')
    <script type="text/javascript">
        @include('layouts._forms._js_filepond', ['id' => 'filepond'])

        @foreach($passport->visas as $visa)
            @include('layouts._forms._js_filepond', ['id' => 'filepond_'.$visa->id])
        @endforeach

        jQuery(document).ready(function () {
            @foreach($passports as $passport)
            $("#visa_type_id__{{ $passport->id }}").select2({placeholder: "Choose One..."});
            $("#is_active__{{ $passport->id }}").select2({placeholder: "Choose One..."});
            $("#visa_entry_id__{{ $passport->id }}").select2({placeholder: "Choose One..."});
            $("#issue_date__{{ $passport->id }}").datepicker();
            $("#expiration_date__{{ $passport->id }}").datepicker();
            @foreach($passport->visas as $visa)
            $("#visa_type_id_{{ $visa->id }}").select2({placeholder: "Choose One..."});
            $("#is_active_{{ $visa->id }}").select2({placeholder: "Choose One..."});
            $("#visa_entry_id_{{ $visa->id }}").select2({placeholder: "Choose One..."});
            $("#issue_date_{{ $visa->id }}").datepicker();
            $("#expiration_date_{{ $visa->id }}").datepicker();
            @endforeach
            @endforeach


            @include('layouts._forms._js_validate_start')
            // Init Form Validation. form.js.validation.template
            @foreach($passports as $passport)
            @foreach($passport->visas as $visa)
            jQuery('#visa-edit-form-{{ $visa->id }}').validate({
                ignore: [],
                rules: {
                    'is_active_{{ $visa->id }}': {
                        required: true
                    },
                    'entry_duration': {
                        number: true
                    },
                    'visa_type_id_{{ $visa->id }}': {
                        required: true
                    },
                    'number': {
                        required: true
                    },
                    'issue_date_{{ $visa->id }}': {
                        required: true
                    },
                    'expiration_date_{{ $visa->id }}': {
                        required: true
                    },
                    'visa_entry_id_{{ $visa->id }}': {
                        required: true
                    }
                },
                messages: {}
            });
            @endforeach
            jQuery('#visa-form-{{ $passport->id }}').validate({
                ignore: [],
                rules: {
                    'entry_duration': {
                        number: true
                    },
                    'is_active__{{ $passport->id }}': {
                        required: true
                    },
                    'visa_type_id__{{ $passport->id }}': {
                        required: true
                    },
                    'image_file_id': {
                        required: true
                    },
                    'number': {
                        required: true
                    },
                    'issue_date__{{ $passport->id }}': {
                        required: true
                    },
                    'expiration_date__{{ $passport->id }}': {
                        required: true
                    },
                    'visa_entry_id__{{ $passport->id }}': {
                        required: true
                    }
                },
                messages: {}
            });
            @endforeach
            @include('layouts._forms._js_validate_end')


        });
    </script>
@endsection