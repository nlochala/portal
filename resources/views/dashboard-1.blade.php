@extends('layouts.backend')

@section('content')
@include('layouts._breadcrumbs', [
    'title' => 'dashboard-1',
    'breadcrumbs' => [
        [
            'page_name' => 'App',
            'page_uri'  => '/'
        ],
        [
            'page_name' => 'dashboard-1',
            'page_uri'  => '/dashboard'
        ]
    ]
])

    <!-- Page Content -->
@include('layouts._content_start')

        <!-- Equal Blocks in Grid -->
<h2 class="content-heading">Equal Blocks in Grid 1</h2>

@include('layouts._panels_start_row', ['has_uniform_length' => true])
@include('layouts._panels_start_column', ['size' => 4])
@include('layouts._panels_start_panel', ['title' => 'Block'])
{{-- START BLOCK OPTIONS --}}
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="fa fa-fw fa-pencil-alt"></i>
                            </button>
                        </div>
{{-- END BLOCK OPTIONS --}}
@include('layouts._panels_start_content')
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
@include('layouts._panels_end_column')



@include('layouts._panels_start_column', ['size' => 4])
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Block</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="fa fa-fw fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras  molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus </p>
                    </div>
                </div>
@include('layouts._panels_end_column')
@include('layouts._panels_start_column', ['size' => 4])
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Block</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="fa fa-fw fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                    </div>
                </div>
@include('layouts._panels_end_column')
@include('layouts._panels_end_row')
        <!-- END Equal Blocks in Grid -->





































        <div class="row">
            <div class="col-md-6 col-xl-5">
                <div class="block block-rounded block-bordered block-themed">
                    <div class="block-header bg-xpro-dark">
                        <h3 class="block-title">Welcome to your app</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p>
                            We’ve put everything together, so you can start working on your Laravel project as soon as possible! Dashmix assets are integrated and work seamlessly with Laravel Mix, so you can use the npm scripts as you would in any other Laravel project.
                        </p>
                        <p>
                            Feel free to use any examples you like from the full versions to build your own pages. <strong>Wish you all the best and happy coding!</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <!-- END Page Content -->
@include('layouts._content_end')
@endsection
