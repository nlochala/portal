<?php

namespace App\Http\Controllers;

use App\Employee;
use App\File;
use App\Helpers\Helpers;
use App\OfficialDocument;
use App\OfficialDocumentType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeOfficialDocumentsController extends EmployeeController
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        if (!request()->hasFile('file_id')) {
            Helpers::flashAlert(
                'danger',
                'A file was not attached to the form. Please try again.',
                'fa fa-info-circle mr-1'
            );

            return redirect()->back();
        }

        if (!$file = File::saveFile($values['file_id'])) {
            return redirect()->back();
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
