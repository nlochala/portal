{{--
$title = Page Title
$breadcrumbs = [['page_name' = name in the breadcrumb, 'page_uri'],[...]
$sub_title = optional
--}}
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $title }}
            @if(isset($subtitle))
                 <br /><em><small><small>{{ $subtitle }}</small></small></em>
            @endif
                </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach($breadcrumbs as $crumb)
                    <li class="breadcrumb-item
                        @if($loop->last)
                            active font-w600" aria-current="page
                        @endif
                           ">{{ link_to($crumb['page_uri'], $crumb['page_name']) }}</li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->