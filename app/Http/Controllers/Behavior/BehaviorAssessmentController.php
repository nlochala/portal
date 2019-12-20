<?php

namespace App\Http\Controllers;

use App\BehaviorAssessment;
use App\BehaviorStandard;
use App\BehaviorStandardItem;
use App\CourseClass;
use App\Events\BehaviorGraded;
use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Quarter;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BehaviorAssessmentController extends Controller
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
     * Display the Behavior Rubric
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function rubric(CourseClass $class, Quarter $quarter)
    {
        $standards = BehaviorStandard::with('items')->get();

        return view('behavior.rubric', compact('class', 'quarter', 'standards'));
    }

    /**
     * Grade the behavior
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function grade(CourseClass $class, Quarter $quarter)
    {
        $students = $class->currentStudents($quarter, 'current');
        $standards = BehaviorStandard::with('items')->get();
        $dropdown_arrays = [];
        $table_head = ['Name'];

        $students->load(['behaviorAssessments' => function ($query) use ($quarter, $class) {
            $query->isQuarter($quarter->id)->isClass($class->id);
        }]);

        $students->load(['behaviorAssessmentAverages' => function ($query) use ($quarter, $class) {
            $query->isQuarter($quarter->id)->isClass($class->id);
        }]);

        foreach ($standards as $standard) {
            $table_head[] = $standard->name;
            $dropdown_arrays[$standard->id] = BehaviorStandardItem::getDropdown('isStandard', $standard->id);
        }

        $table_head[] = 'Total';
        $table_head[] = 'Actions';

        return view('behavior.grading', compact('class', 'quarter', 'students', 'standards', 'table_head', 'dropdown_arrays'));
    }

    /**
     * Save the student behavior grade.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return RedirectResponse
     */
    public function store(CourseClass $class, Quarter $quarter)
    {
        $values = request()->all();
        $student_id = $values['student_id'];
        unset($values['_token']);
        unset($values['student_id']);

        // loop through the standard ids
        foreach ($values as $key => $id) {
            $standard_id = explode('-', $key)[1];
            // Update an existing standard
            if ($assessment = BehaviorAssessment::isQuarter($quarter->id)->isStudent($student_id)
                ->isClass($class->id)->isStandard($standard_id)->first()) {
                if ($assessment->item->id !== $id) {
                    $assessment = DatabaseHelpers::dbAddAudit($assessment);
                    $assessment->behavior_standard_item_id = $id;
                    $assessment->save();
                }
            }else{
                // Create a new record.
                $assessment = DatabaseHelpers::dbAddAudit(new BehaviorAssessment());
                $assessment->quarter_id = $quarter->id;
                $assessment->student_id = $student_id;
                $assessment->class_id = $class->id;
                $assessment->behavior_standard_id = $standard_id;
                $assessment->behavior_standard_item_id = $id;
                $assessment->save();
            }
        }

        event( new BehaviorGraded($quarter, $class, Student::findOrFail($student_id)));
        return redirect()->back();
    }
}
