@include('layouts._panels_start_row',['has_uniform_length' => false])
@include('layouts._panels_start_column', ['size' => 8])
<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'ID Card (Number: xxxxxx' . substr($id_card->number, -4) . ')', 'with_block' => true])
<div class="block-options" style="float: left">
    @if($id_card->is_active)
        <button type="button" class="btn btn-hero-sm btn-hero-success">
            <i class="fa fa-check-circle"></i> ACTIVE
            @else
                <button type="button" class="btn btn-hero-sm btn-hero-light">
                    <i class="fa fa-pause-circle"></i> CANCELLED
                    @endif
                </button>
</div>
</div>
{{-- END BLOCK OPTIONS --}}
@include('layouts._panels_start_content')
@if($id_card->is_active)
    <button type="button"
            class="btn btn-outline-success mr-1 mb-3" {!! \App\Helpers\Helpers::onClick("/employee/$employee->uuid/create_id_card") !!}>
        <i class="fa fa-plus fa-plus mr-1"></i> Add New ID Card
    </button>
@endif
<button type="button"
        class="btn btn-outline-primary mr-1 mb-3" {!! \App\Helpers\Helpers::onClick("/employee/$employee->uuid/id_card/$id_card->uuid/update_id_card") !!}>
    <i class="fa fa-fw fa-pen mr-1"></i> Update ID Card
</button>
@if($id_card->is_active)
    <button type="button"
            class="btn btn-outline-dark mr-1 mb-3" {!! \App\Helpers\Helpers::onClick("/id_card/$id_card->uuid/cancel") !!}>
        <i class="fa fa-pause-circle mr-1"></i> Cancel ID Card
    </button>
@else
    <button type="button"
            class="btn btn-outline-danger mr-1 mb-3" {!! \App\Helpers\Helpers::onClick("/id_card/$id_card->uuid/delete") !!}>
        <i class="fa fa-trash mr-1"></i> Delete ID Card
    </button>
@endif
@include('_tables.new-table-plain',['id' => 'id_card-table'])
<tr>
    <td><strong>Name: </strong></td>
    <td>{{ $id_card->name }}</td>
</tr>
<tr>
    <td><strong>Number: </strong></td>
    <td>{{ $id_card->number}}</td>
</tr>
<tr>
    <td><strong>Issue Date: </strong></td>
    <td>{{ $id_card->issue_date->format('Y-m-d') }}</td>
</tr>
<tr>
    <td><strong>Expiration Date: </strong></td>
    <td>{{ $id_card->expiration_date->format('Y-m-d') }} <br/>
        {!! \App\Helpers\Helpers::getExpirationBadge($id_card->expiration_date, 'ID Card') !!}
    </td>
</tr>
@include('_tables.end-new-table')
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
@include('layouts._panels_end_column')
@include('layouts._panels_start_column', ['size' => 4])
<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => 'Card Images', 'with_block' => false])
@include('layouts._panels_start_content')
<div class="options-container" style="text-align: center">
    <img class="img-fluid options-item rounded border border-dark" src="{{ $id_card->frontImage->renderImage() }}"
         alt=""
         style="width: 75%">
    <div class="options-overlay bg-black-75" style="width: 75%; margin: auto;">
        <div class="options-overlay-content">
            <h3 class="h4 text-white mb-2">ID Card (Front)</h3>
            <h4 class="h6 text-white-75 mb-3">File
                Size: {{ \App\Helpers\Helpers::formatBytes($id_card->frontImage->size) }}
                <br/>
                Upload Date: {{ $id_card->frontImage->created_at }}</h4>
            <br/>
            <a class="btn btn-sm btn-primary" href="{{ $id_card->frontImage->originalFile->downloadUrl() }}">
                <i class="si si-cloud-download mr-1"></i> Download
                ({{ \App\Helpers\Helpers::formatBytes($id_card->frontImage->originalFile->size) }})
            </a>
        </div>
    </div>
</div>
<hr/>
<div class="options-container" style="text-align: center; padding-bottom: 25px">
    <img class="img-fluid options-item rounded border border-dark" src="{{ $id_card->backImage->renderImage() }}" alt=""
         style="width: 75%">
    <div class="options-overlay bg-black-75" style="width: 75%; margin: auto;">
        <div class="options-overlay-content">
            <h3 class="h4 text-white mb-2">ID Card (Back)</h3>
            <h4 class="h6 text-white-75 mb-3">File
                Size: {{ \App\Helpers\Helpers::formatBytes($id_card->backImage->size) }}
                <br/>
                Upload Date: {{ $id_card->backImage->created_at }}</h4>
            <br/>
            <a class="btn btn-sm btn-primary" href="{{ $id_card->backImage->originalFile->downloadUrl() }}">
                <i class="si si-cloud-download mr-1"></i> Download
                ({{ \App\Helpers\Helpers::formatBytes($id_card->backImage->originalFile->size) }})
            </a>
        </div>
    </div>
</div>
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
@include('layouts._panels_end_column')
@include('layouts._panels_end_row')
