@extends('layouts.backend')

@section('content')
    <!-- Add Content Title Here b.breadcrumbs -->
    @include('student._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $student->person->fullName()}}'s Profile</h1>
    <!--
    panel.row
    panel.column
    panel.panel
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
    @include('layouts._panels_start_row',['has_uniform_length' => false])
    @include('layouts._panels_start_column', ['size' => 7])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Overview'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <!-- START FORM----------------------------------------------------------------------------->

    {!! Form::model($student->person,['files' => true, 'method' => 'PATCH','id' => 'admin-form','url' => request()->getRequestUri()]) !!}

    @include('layouts._forms._heading',['title' => 'Biographical Information'])
    @include('layouts._forms._row_start', ['size' => 12])
    @include('person._create_form_biographical', ['type' => 'student'])
    @include('layouts._forms._row_end')
    @include('layouts._forms._heading',['title' => 'Demographic Information'])
    @include('layouts._forms._row_start', ['size' => 12])
    @include('person._create_form_demographic')
    @include('layouts._forms._row_end')
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->

    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_start_column', ['size' => 3])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Profile Picture'])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')
    <div class="col-md-12 animated fadeIn" style="padding-bottom: 20px">
        @if($image_data)
            <div class="options-container" style="text-align: center">
                <img dusk="profile-image" class="img-fluid options-item rounded border border-2x border-dark" src="{{ $image_data }}" alt="">
                <div class="options-overlay bg-black-75">
                    <div class="options-overlay-content">
                        <h3 class="h4 text-white mb-2">Profile Image</h3>
                        <h4 class="h6 text-white-75 mb-3">File Size: {{ $image_size }}<br/>
                            Upload Date: {{ $image_created }}</h4>
                        <br/>
                        <a class="btn btn-sm btn-primary" href="{{ $original_image_url }}">
                            <i class="si si-cloud-download mr-1"></i> Download ({{ $original_image_size }})
                        </a>
                    </div>
                </div>
            </div>
            <hr/>
        @endif
    <!-- START FORM----------------------------------------------------------------------------->

        {!! Form::open(['files' => true, 'id' => 'profile-form','url' => request()->getRequestUri()]) !!}

        <h5>Upload New Image</h5>
        @include('layouts._forms._input_file_upload', [
            'name' => 'upload',
            'label' => '',
            'required' => true,
            'options' => ['class' => 'filepond', 'accept' => 'image/*']
        ])

        <div class="block-content block-content-full block-content-sm bg-body-light text-right">
            <button type="submit" class="btn btn-sm btn-outline-primary" data-toggle="click-ripple">
                <i class="fa fa-check"></i> Submit
            </button>
        </div>
    {{ Form::close() }}
    <!-- END FORM----------------------------------------------------------------------------->
    </div>
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->

    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')
    @include('layouts._content_end')
@endsection


@section('js_after')

    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentProfileRequest','#admin-form') !!}
    {!! JsValidator::formRequest('\App\Http\Requests\StoreStudentImageRequest','#profile-form') !!}

    <script type="text/javascript">

        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageEdit
        );

        const upload = FilePond.create(
            document.querySelector('#upload'),
            {
                labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
                imagePreviewHeight: 200,
                stylePanelLayout: 'integrated',
                styleLoadIndicatorPosition: 'center bottom',
                styleProgressIndicatorPosition: 'right bottom',
                styleButtonRemoveItemPosition: 'left bottom',
                styleButtonProcessItemPosition: 'right bottom',

                server: {
                    process: '/api/store_file',
                },

                // Use Doka.js as image editor
                imageEditEditor: Doka.create()
            }
        );

        jQuery(document).ready(function () {
            $("#title").select2({placeholder: "Choose one...",});
            $("#country_of_birth_id").select2({placeholder: "Choose One..."});
            $("#language_primary_id").select2({placeholder: "Choose One..."});
            $("#language_secondary_id").select2({placeholder: "Choose One..."});
            $("#language_tertiary_id").select2({placeholder: "Choose One..."});
            $("#ethnicity_id").select2({placeholder: "Choose One..."});
            $("#dob").datepicker();
        });
    </script>
@endsection