@include('layouts._panels_start_row',['has_uniform_length' => true])
@include('layouts._panels_start_column', ['size' => 12])
<!-------------------------------------------------------------------------------->
<!----------------------------------New Panel ------------------------------------>
@include('layouts._panels_start_panel', ['title' => "Passport (Number: {$passport->number})", 'with_block' => true])
<div class="block-options" style="float: left">
    @if($passport->is_active)
        <button dusk="btn-active-{{ $passport->id }}" type="button" class="btn btn-hero-sm btn-hero-success">
            <i class="fa fa-check-circle"></i> ACTIVE
            @else
                <button dusk="btn-cancelled-{{ $passport->id }}" type="button" class="btn btn-hero-sm btn-hero-light">
                    <i class="fa fa-pause-circle"></i> CANCELLED
                    @endif
                </button>
</div>
</div>
{{-- END BLOCK OPTIONS --}}
{{-- START BLOCK OPTIONS panel.block --}}
@include('layouts._panels_start_content')
@include('layouts._content_row_start')
@include('layouts._content_column_start', ['size' => 8, 'class' => '', 'style' => ''])
@can('employees.update.government_documents')
@if($passport->is_active)
    <button type="button" dusk="btn-new-passport"
            class="btn btn-outline-success mr-1 mb-3" {!! \App\Helpers\ViewHelpers::onClick("/employee/$employee->uuid/create_passport") !!}>
        <i class="fa fa-plus fa-plus mr-1"></i> Add New Passport
    </button>
@endif

<button type="button" dusk="btn-update-passport-{{ $passport->id }}"
        class="btn btn-outline-primary mr-1 mb-3" {!! \App\Helpers\ViewHelpers::onClick("/employee/$employee->uuid/passport/$passport->uuid/update_passport") !!}>
    <i class="fa fa-fw fa-pen mr-1"></i> Update Passport
</button>

@if($passport->is_active)
    <button type="button" dusk="btn-cancel-passport-{{ $passport->id }}"
            class="btn btn-outline-dark mr-1 mb-3" {!! \App\Helpers\ViewHelpers::onClick("/passport/$passport->uuid/cancel") !!}>
        <i class="fa fa-pause-circle mr-1"></i> Cancel Passport
    </button>
@else
    <button type="button" dusk="btn-delete-passport-{{ $passport->id }}"
            class="btn btn-outline-danger mr-1 mb-3" {!! \App\Helpers\ViewHelpers::onClick("/passport/$passport->uuid/delete") !!}>
        <i class="fa fa-trash mr-1"></i> Delete Passport
    </button>
@endif
@endcan
@include('_tables.new-table-plain',['id' => 'passport-table'])
<tr>
    <td><strong>Country: </strong></td>
    <td>{{ $passport->country->name }}</td>
</tr>
<tr>
    <td><strong>Family Name: </strong></td>
    <td>{{ $passport->family_name }}</td>
</tr>
<tr>
    <td><strong>Given Name: </strong></td>
    <td>{{ $passport->given_name}}</td>
</tr>
<tr>
    <td><strong>Number: </strong></td>
    <td>{{ $passport->number }}</td>
</tr>
<tr>
    <td><strong>Issue Date: </strong></td>
    <td>{{ $passport->issue_date->format('Y-m-d') }}</td>
</tr>
<tr>
    <td><strong>Expiration Date: </strong></td>
    <td>{{ $passport->expiration_date->format('Y-m-d') }} <br/>
        {!! \App\Helpers\ViewHelpers::getExpirationBadge($passport->expiration_date, 'Passport') !!}
    </td>
</tr>
@include('_tables.end-new-table')
@include('layouts._content_column_end')
@include('layouts._content_column_start', ['size' => 4, 'class' => '', 'style' => 'text-align: center'])
<div class="options-container">
    <img class="img-fluid options-item rounded border border-dark" src="{{ $passport->image->renderImage() }}" alt=""
         style="width: 75%">
    <div class="options-overlay bg-black-75" style="width: 75%; margin: auto;">
        <div class="options-overlay-content">
            <h3 class="h4 text-white mb-2">Passport Image</h3>
            <h4 class="h6 text-white-75 mb-3">File Size: {{ \App\Helpers\FileHelpers::formatBytes($passport->image->size) }}
                <br/>
                Upload Date: {{ $passport->image->created_at }}</h4>
            <br/>
            <a class="btn btn-sm btn-primary" href="{{ $passport->image->originalFile->downloadUrl() }}">
                <i class="si si-cloud-download mr-1"></i> Download
                ({{ \App\Helpers\FileHelpers::formatBytes($passport->image->originalFile->size) }})
            </a>
        </div>
    </div>
</div>
@include('layouts._content_column_end')
@include('layouts._content_row_end')
@include('layouts._content_row_start')
@include('layouts._content_column_start', ['size' => 12, 'class' => '', 'style' => ''])
<h4 class="w-100">Visas</h4>
<!-- TABLE OF VISAS -->
@if($passport->visas->isEmpty())
    <small><em>Nothing to Display</em></small> <br/><br/>
@else
    @include('_tables.new-table',['id' => 'visa-table', 'table_head' => ['Status','Type','Number','Entries', 'Issue Date', 'Expiration Date', 'Actions']])
    @foreach($passport->visas->sortByDesc('issue_date') as $visa)
        <tr>
            <td>
                @if($visa->is_active)
                    <span dusk="table-is-active-visa-{{ $visa->id }}" class="badge badge-success"> <i class="fa fa-check"></i> ACTIVE </span>
                @else
                    <span dusk="table-is-active-visa-{{ $visa->id }}" class="badge badge-secondary"> <i class="far fa-pause-circle"></i> Cancelled</span>
                @endif
            </td>
            <td>
                <a class="font-weight-bolder" data-toggle="tooltip" title="{{ $visa->visaType->description }}"
                   href="javascript:void(0)">{{ $visa->visaType->formatted_name }}</a>
            </td>
            <td>{{ $visa->number }}</td>
            <td>{{ $visa->visaEntry->name}}
                @if($visa->entry_duration)
                    ({{ $visa->entry_duration }} Days)
                @endif
            </td>
            <td>{{ $visa->issue_date->format('Y-m-d') }}</td>
            <td>{{ $visa->expiration_date->format('Y-m-d') }}<br/>
                {!! \App\Helpers\ViewHelpers::getExpirationBadge($visa->expiration_date,null,30,180) !!}
            </td>
            <td>
                @can('employees.update.government_documents')
                <div class="btn-group">
                    <button type="button" dusk="btn-download-image-{{ $visa->id }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip"
                            title="Download Info Page"
                            onclick="window.location.href='{{ $visa->image->originalFile->downloadUrl() }}'">
                        <i class="fa fa-file-download"></i>
                    </button>
                    <button type="button" dusk="btn-modal-block-visa-{{ $visa->id }}" class="btn btn-sm btn-outline-primary" data-toggle="modal" title="Edit"
                            data-target="#modal-block-visa-{{ $visa->id }}">
                        <i class="fa fa-pen"></i>
                    </button>
                    @if($visa->is_active)
                        <button type="button" dusk="btn-cancel-visa-{{ $visa->id }}" class="btn btn-sm btn-outline-dark" data-toggle="tooltip" title="Cancel"
                                onclick="window.location.href='/visa/{{ $visa->uuid }}/cancel'">
                            <i class="fa fa-pause-circle"></i>
                        </button>
                    @endif
                </div>
                @if(!$visa->is_active)
                    <div class="btn-group" style="float: right">
                        <button type="button" dusk="btn-delete-visa-{{ $visa->id }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                onclick="window.location.href='/visa/{{ $visa->uuid }}/delete'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                @endif
                    @endcan
            </td>
        </tr>
    @endforeach
    @include('_tables.end-new-table')
@endif
@can('employees.update.government_documents')
    <button type="button" dusk="btn-modal-block-visa-form-{{ $passport->id }}" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
        data-target="#modal-block-visa-form-{{ $passport->id }}">
    <i class="fa fa-plus"> </i> Add New Visa
</button>
    @endcan
<!------   data-toggle="modal" data-target="#modal-block-visa-form". ----->
@include('layouts._content_column_end')
@include('layouts._content_row_end')
@include('layouts._panels_end_content')
@include('layouts._panels_end_panel')
<!-------------------------------------------------------------------------------->
<!-------------------------------------------------------------------------------->
@include('layouts._panels_end_column')
@include('layouts._panels_end_row')
@can('employees.update.government_documents')
@foreach($passport->visas as $visa)
    <!-------------------------------- Modal: Visa Edit Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-visa-' . $visa->id,
        'title' => "Edit Visa (#$visa->number)"
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::model($visa,['method' => 'PATCH','files' => true, 'id' => "visa-edit-form-$visa->id",'url' => "/employee/$employee->uuid/visa/$visa->uuid/update_visa"]) !!}
    @include('person._edit_form_visa', ['visa' => $visa])
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Visa Edit END------------------------------------------->
@endforeach
<!-------------------------------- Modal: New Visa Start------------------------------------------->
@include('layouts._modal_panel_start',[
    'id' => 'modal-block-visa-form-' . $passport->id,
    'title' => "New Visa for Passport (#$passport->number)"
])
<!-- START FORM----------------------------------------------------------------------------->

{!! Form::open(['files' => true, 'id' => "visa-form-$passport->id",'url' => "/employee/$employee->uuid/passport/$passport->uuid/create_visa"]) !!}
@include('person._create_form_visa',['passport' => $passport])
@include('layouts._forms._form_close')
<!-- END FORM----------------------------------------------------------------------------->

@include('layouts._modal_panel_end')
<!-------------------------------- Modal: New Visa END------------------------------------------->
@endcan
