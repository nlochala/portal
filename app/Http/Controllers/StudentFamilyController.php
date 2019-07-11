<?php

namespace App\Http\Controllers;

use App\Family;
use App\Student;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class StudentFamilyController extends StudentController
{
    /**
     * Display the new family form.
     *
     * @param Student $student
     * @return Factory|View
     */
    public function newFamily(Student $student)
    {
        return view('student.new_family', compact('student'));
    }

    /**
     * Attach student to existing family.
     *
     * @param Student $student
     * @param Family $family
     * @return RedirectResponse
     */
    public function addToExistingFamily(Student $student, Family $family)
    {
        $student = Helpers::dbAddAudit($student);
        $student->family_id = $family->id;
        Helpers::flash($student->save(), 'student', 'added');

        return redirect()->to('family/'.$family->uuid);
    }

    /**
     * Create a new family and attach it to the student.
     *
     * @param Student $student
     * @return RedirectResponse
     */
    public function createNewFamily(Student $student)
    {
        $values = [];
        $values = Helpers::dbAddAudit($values);
        $family = Family::create($values);

        $student->family_id = $family->id;
        Helpers::flash($student->save(), 'student', 'added');

        return redirect()->to('family/'.$family->uuid);
    }

    /**
     * Show either the family page or the new family page.
     *
     * @param Student $student
     * @return RedirectResponse
     */
    public function viewFamily(Student $student)
    {
        return $student->family_id ?
            redirect()->to('family/'.$student->family->uuid)
            :
            redirect()->to('student/'.$student->uuid.'/new_family');
    }
}
