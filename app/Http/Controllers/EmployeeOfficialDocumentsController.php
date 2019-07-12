<?php

namespace App\Http\Controllers;

use App\File;
use App\Employee;
use App\Helpers\Helpers;
use App\OfficialDocument;
use Illuminate\View\View;
use App\OfficialDocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class EmployeeOfficialDocumentsController extends EmployeeController
{
    /**
     * Display the official documents of a given employee.
     *
     * @param Employee $employee
     *
     * @return Factory|View
     */
    public function officialDocuments(Employee $employee)
    {
        $document_types = OfficialDocumentType::getDropdown();
        $documents = $employee->person->officialDocuments->load('officialDocumentType', 'file', 'file.extension');

        return view('employee.official_documents', compact(
            'employee',
            'document_types',
            'documents'
        ));
    }

    /**
     * Store the uploaded document.
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function store(Employee $employee)
    {
        $values = Helpers::dbAddAudit(request()->all());

        if (! request()->has('upload')) {
            Helpers::flashAlert(
                'danger',
                'Please upload an official document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file = File::getFile($values['upload'])) {
            Helpers::flashAlert(
                'danger',
                'Could not find the uploaded document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        if (! $file->saveFile()) {
            Helpers::flashAlert(
                'danger',
                'There was an issue saving your document. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back()->withInput();
        }

        $values['file_id'] = $file->id;
        $values['person_id'] = $employee->person->id;

        /* @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(OfficialDocument::create($values), 'document');

        return redirect()->back();
    }

    /**
     * Delete the official document.
     *
     * @param Employee         $employee
     * @param OfficialDocument $document
     *
     * @return RedirectResponse
     */
    public function delete(Employee $employee, OfficialDocument $document)
    {
        $document = Helpers::dbAddAudit($document);
        Helpers::flash($document->delete(), 'document', 'deleted');

        return redirect()->back();
    }
}
