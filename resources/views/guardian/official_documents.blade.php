@extends('layouts.backend')

@section('content')
    @include('guardian._horizontal_menu')
    @include('layouts._content_start')
    <h1 class="font-w400" style="text-align: center">{{ $guardian->person->fullName()}}'s Official Documents</h1>
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

    @include('layouts._panels_start_row',['has_uniform_length' => true])
    @include('layouts._panels_start_column', ['size' => 12])
    <!-------------------------------------------------------------------------------->
    <!----------------------------------New Panel ------------------------------------>
    @include('layouts._panels_start_panel', ['title' => 'Uploaded Documents', 'with_block' => false])
    {{-- START BLOCK OPTIONS panel.block --}}
    @include('layouts._panels_start_content')

    <!-- TABLE OF DOCUMENTS -->
    @if($documents->isEmpty())
        <small><em>Nothing to Display</em></small>
    @else
        @include('_tables.new-table',['id' => 'document-table', 'table_head' => ['Type','Name','File Type','Size','Visibility','Uploaded Date','Actions']])
        @foreach($documents as $document)
            <tr>
                <td><strong>{{ $document->officialDocumentType->name }}</strong></td>
                <td><a href="{{ $document->file->downloadUrl() }}">
                        {{ $document->file->public_name }}.{{ $document->file->extension->name }}</a></td>
                <td>{{ $document->file->extension->type }}</td>
                <td>{{ \App\Helpers\Helpers::formatBytes($document->file->size) }}</td>
                <td>{{ strtoupper($document->file->driver) }}</td>
                <td>{{ $document->file->created_at }}</td>
                <td>
                    @can('guardian.update.official_documents')
                    <div class="btn-group">
                        <button type="button" dusk="btn-download-document-{{ $document->id }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip"
                                title="Download"
                                onclick="window.location.href='{{ $document->file->downloadUrl() }}'">
                            <i class="fa fa-download"></i>
                        </button>
                        <button type="button" dusk="btn-delete-document-{{ $document->id }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete"
                                onclick="window.location.href='/guardian/{{ $guardian->uuid }}/official_documents/{{ $document->uuid }}/delete'">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                        @endcan
                </td>
            </tr>
        @endforeach
        @include('_tables.end-new-table')
    @endif
    @can('guardian.update.official_documents')
        <hr/>
        <button type="button" dusk="btn-modal-block-new-document" class="btn btn-outline-success mr-1 mb-3" data-toggle="modal"
            data-target="#modal-block-new-document">
        <i class="fa fa-plus"></i> Upload New Document
    </button>
        @endcan
    @include('layouts._panels_end_content')
    @include('layouts._panels_end_panel')
    <!-------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------->
    @include('layouts._panels_end_column')
    @include('layouts._panels_end_row')

    @include('layouts._content_end')

    <!-------------------------------- Modal: Add New Official Document Start------------------------------------------->
    @include('layouts._modal_panel_start',[
        'id' => 'modal-block-new-document',
        'title' => 'Add New Official Document'
    ])
    <!-- START FORM----------------------------------------------------------------------------->
    {!! Form::open(['files' => true, 'id' => 'admin-form','url' => request()->getRequestUri()]) !!}
    <!----------------------------------------------------------------------------->
    <!---------------------------New official_document_type_id dropdown----------------------------->
    @include('layouts._forms._input_dropdown',[
        'name' => 'official_document_type_id',
        'label' => 'Document Type',
        'array' => $document_types,
        'class' => null,
        'selected' => null,
        'required' => true
      ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    <!---------------------------New official document file field----------------------------->
    @include('layouts._forms._input_file_upload', [
        'name' => 'upload',
        'label' => 'Upload Document',
        'required' => true,
        'options' => ['class' => 'filepond']
    ])
    <!----------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------->
    @include('layouts._forms._form_close')
    <!-- END FORM----------------------------------------------------------------------------->
    @include('layouts._modal_panel_end')
    <!-------------------------------- Modal: Add New Official Document END------------------------------------------->
    <!------   data-toggle="modal" data-target="#modal-block-new-document". ----->
@endsection

@section('js_after')
    {!! JsValidator::formRequest('\App\Http\Requests\StoreGuardianOfficialDocumentRequest'); !!}

    <script type="text/javascript">
        @include('layouts._forms._js_filepond', ['id' => 'upload'])

        jQuery(document).ready(function () {
            $("#official_document_type_id").select2({placeholder: "Choose One..."});
        });
    </script>
@endsection
