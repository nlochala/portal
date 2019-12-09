<?php

namespace App\Http\Controllers;

use App\File;
use App\Guardian;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use App\OfficialDocument;
use Illuminate\View\View;
use App\OfficialDocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GuardianOfficialDocumentsController extends GuardianController
{

    /**
     * Display the official documents of a given guardian.
     *
     * @param Guardian $guardian
     *
     * @return Factory|View
     */
    public function officialDocuments(Guardian $guardian)
    {
        $document_types = OfficialDocumentType::getDropdown();
        $documents = $guardian->person->officialDocuments->load('officialDocumentType', 'file', 'file.extension');

        return view('guardian.official_documents', compact(
            'guardian',
            'document_types',
            'documents'
        ));
    }

    /**
     * Store the uploaded document.
     *
     * @param Guardian $guardian
     *
     * @return RedirectResponse
     */
    public function store(Guardian $guardian)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());

        if (! request()->has('upload')) {
            ViewHelpers::flashAlert(
                'danger',
                'Please upload an official document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file = File::getFile($values['upload'])) {
            ViewHelpers::flashAlert(
                'danger',
                'Could not find the uploaded document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file->saveFile()) {
            ViewHelpers::flashAlert(
                'danger',
                'There was an issue saving your document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        $values['file_id'] = $file->id;
        $values['person_id'] = $guardian->person->id;

        /* @noinspection PhpUndefinedMethodInspection */
       ViewHelpers::flash(OfficialDocument::create($values), 'document');

        return redirect()->back();
    }

    /**
     * Delete the official document.
     *
     * @param Guardian         $guardian
     * @param OfficialDocument $document
     *
     * @return RedirectResponse
     */
    public function delete(Guardian $guardian, OfficialDocument $document)
    {
        $document = DatabaseHelpers::dbAddAudit($document);
       ViewHelpers::flash($document->delete(), 'document', 'deleted');

        return redirect()->back();
    }
}
