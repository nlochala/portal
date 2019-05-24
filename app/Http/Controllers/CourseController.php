<?php

namespace App\Http\Controllers;

use App\Year;
use App\Course;
use App\CourseType;
use App\Department;
use App\GradeLevel;
use App\GradeScale;
use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use App\CourseTranscriptType;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $courses = Course::getDropdown('current');
        $grade_levels = GradeLevel::getDropdown('current');
        $course_types = CourseType::getDropdown();
        $transcript_types = CourseTranscriptType::getDropdown();
        $grade_scales = GradeScale::getDropdown();
        $departments = Department::getDropdown();
        $years = Year::getDropdown();

        return view('course.index', compact(
            'courses',
            'grade_levels',
            'course_types',
            'transcript_types',
            'grade_scales',
            'departments',
            'years'
        ));
    }

    /**
     * Show the selected course.
     *
     * @param Course $course
     * @return Factory|View
     */
    public function show(Course $course)
    {
        $course->load(
            'year',
            'prerequisites',
            'corequisites',
            'equivalents',
            'gradeLevels',
            'type',
            'transcriptType',
            'gradeScale',
            'department',
            'year',
            'createdBy',
            'updatedBy'
            );

        $report_card_checkbox = Course::$reportCardCheckbox;

        return view('course.show', compact('course', 'report_card_checkbox'));
    }

    /**
     * Store Report Card Options.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeReportCardOptions(Course $course)
    {
        $values = Helpers::dbAddAudit(request()->all());
        $expected_items = Course::$reportCardCheckbox;

        foreach ($expected_items as $item => $value) {
            $values[$item] = Arr::has($values, $item) ? true : false;
        }

        Helpers::flash($course->update($values), 'report card options', 'updated');

        return redirect()->back();
    }
}
