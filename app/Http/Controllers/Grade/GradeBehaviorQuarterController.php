<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseHelpers;
use App\Helpers\ViewHelpers;
use App\Quarter;
use App\GradeScale;
use App\CourseClass;
use App\Helpers\Helpers;
use Illuminate\View\View;
use App\GradeScaleStandard;
use App\GradeBehaviorQuarter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class GradeBehaviorQuarterController extends Controller
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
     * Show the approval form.
     *
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function approvalForm(Quarter $quarter)
    {
        $quarter_dropdown = Quarter::getDropdown(null, env('SCHOOL_YEAR_ID'));
        $grade_scale = GradeScale::findOrFail(env('BEHAVIOR_GRADE_SCALE_ID'));
        $grade_scale_dropdown = GradeScaleStandard::getDropdown($grade_scale->id);

        return view('class.behavior_approval', compact(
            'quarter',
            'quarter_dropdown',
            'grade_scale',
            'grade_scale_dropdown'
        ));
    }

    /**
     * Process the change of quarter form.
     *
     * @return RedirectResponse
     */
    public function processChangeQuarter()
    {
        $quarter_id = request('quarter_id');
        $quarter = Quarter::findOrFail($quarter_id);

        return redirect()->to('/report/behavior/approve/'.$quarter->uuid);
    }

    /**
     * Show the grade entry point for behavior assessments.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return Factory|View
     */
    public function grade(CourseClass $class, Quarter $quarter)
    {
        $relationship = $quarter->getClassRelationship();
        $class->load($relationship.'.behaviorGrades.item');

        $grade_scale = GradeScale::findOrFail(env('BEHAVIOR_GRADE_SCALE_ID'));
        $grade_scale_dropdown = GradeScaleStandard::getDropdown($grade_scale->id);

        return view('class.behavior', compact('class', 'quarter', 'relationship', 'grade_scale_dropdown'));
    }

    /**
     * Process the new behavior grades.
     *
     * @param CourseClass $class
     * @param Quarter $quarter
     * @return RedirectResponse
     */
    public function processGrades(CourseClass $class, Quarter $quarter)
    {
        $grades_array = [];
        $values = request()->all();
        $grade_scale_id = env('BEHAVIOR_GRADE_SCALE_ID');
        unset($values['_token']);

        foreach ($values as $key => $value) {
            $exploded = explode('_', $key);
            $grades_array[$exploded[0]][$exploded[1]] = $value;
        }

//        dd($grades_array);

        foreach ($grades_array as $student_id => $items) {
            if ($items['comment'] === null) {
                $items['comment'] = '';
            }

            $insert_values = [
                'grade_scale_id' => $grade_scale_id,
                'grade_scale_item_id' => $items['dropdown'],
                'comment' => $items['comment'],
                'quarter_id' => $quarter->id,
                'student_id' => $student_id,
            ];

//            dd($insert_values)

            if ($grade = GradeBehaviorQuarter::where('student_id', $student_id)->where('quarter_id', $quarter->id)->first()) {
                $grade = DatabaseHelpers::dbAddAudit($grade);
                $grade->update($insert_values);
            } else {
                $insert_values = DatabaseHelpers::dbAddAudit($insert_values);
                GradeBehaviorQuarter::create($insert_values);
            }
        }

       ViewHelpers::flash(true, 'student grade', 'updated');

        return redirect()->back();
    }
}
