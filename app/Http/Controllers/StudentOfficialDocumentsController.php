<?php

namespace App\Http\Controllers;

use App\File;
use App\Student;
use App\Helpers\Helpers;
use App\OfficialDocument;
use Illuminate\View\View;
use App\OfficialDocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentOfficialDocumentsController extends StudentController
{

    /**
     * Display the official documents of a given student.
     *
     * @param Student $student
     *
     * @return Factory|View
     */
    public function officialDocuments(Student $student)
    {
        $document_types = OfficialDocumentType::getDropdown();
        $documents = $student->person->officialDocuments->load('officialDocumentType', 'file', 'file.extension');

        return view('student.official_documents', compact(
            'student',
            'document_types',
            'documents'
        ));
    }

    /**
     * Store the uploaded document.
     *
     * @param Student $student
     *
     * @return RedirectResponse
     */
    public function store(Student $student)
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
        $values['person_id'] = $student->person->id;

        /* @noinspection PhpUndefinedMethodInspection */
        Helpers::flash(OfficialDocument::create($values), 'document');

        return redirect()->back();
    }

    /**
     * Delete the official document.
     *
     * @param Student         $student
     * @param OfficialDocument $document
     *
     * @return RedirectResponse
     */
    public function delete(Student $student, OfficialDocument $document)
    {
        $document = Helpers::dbAddAudit($document);
        Helpers::flash($document->delete(), 'document', 'deleted');

        return redirect()->back();
    }
}
