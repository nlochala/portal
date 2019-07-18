<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Profile Picture'])
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
<div class="col-md-12 animated fadeIn" style="padding-bottom: 20px">
    <div class="options-container" style="text-align: center">
        {!! $person->profileImage(250) !!}
{{--        <div class="options-overlay bg-black-75">--}}
{{--            <div class="options-overlay-content">--}}
{{--                <h3 class="h4 text-white mb-2">Profile Image</h3>--}}
{{--                <h4 class="h6 text-white-75 mb-3">File Size: {{ $image_size }}<br/>--}}
{{--                    Upload Date: {{ $image_created }}</h4>--}}
{{--                <br/>--}}
{{--                <a class="btn btn-sm btn-primary" href="{{ $original_image_url }}">--}}
{{--                    <i class="si si-cloud-download mr-1"></i> Download ({{ $original_image_size }})--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->