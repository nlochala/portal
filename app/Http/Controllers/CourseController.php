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
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
     * Store a new course.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $values = Helpers::dbAddAudit(request()->all());
        $values['short_name'] = strtoupper($values['short_name']);
        $course = Course::create($values);
        Helpers::flash($course, 'course', 'created');

        if ($course) {
            return redirect()->to('course/'.$course->uuid);
        }

        return redirect()->back()->withInput();
    }

    /**
     * Show the selected course.
     *
     * @param Course $course
     * @return Factory|View
     */
    public function show(Course $course)
    {
        $add_course_dropdown = Course::current()->with('type', 'department')->get();
        $transcript_types_dropdown = CourseTranscriptType::getDropdown();
        $grade_level_dropdown = GradeLevel::getDropdown('current');

        $course_types = CourseType::getDropdown();
        $transcript_types = CourseTranscriptType::getDropdown();
        $grade_scales = GradeScale::getDropdown();
        $departments = Department::getDropdown();
        $years = Year::getDropdown();

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

        return view('course.show', compact(
            'course',
            'report_card_checkbox',
            'add_course_dropdown',
            'transcript_types_dropdown',
            'grade_level_dropdown',
            'course_types',
            'transcript_types',
            'grade_scales',
            'departments',
            'years'
        ));
    }

    /**
     * Display the audits of a specific course.
     *
     * @param Course $course
     * @return Factory|View
     */
    public function showAudits(Course $course)
    {
        $audits = $course->audits;

        return view('course.audits', compact('audits', 'course'));
    }

    /**
     * Store Report Card Options.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeCourseDisplayOptions(Course $course)
    {
        $values = Helpers::dbAddAudit(request()->all());
        $expected_items = Course::$reportCardCheckbox;

        foreach ($expected_items as $item => $value) {
            $values[$item] = Arr::has($values, $item) ? true : false;
        }

        Helpers::flash($course->update($values), 'course display options', 'updated');

        return redirect()->back();
    }

    /**
     * Process the transcript options.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeTranscriptOptions(Course $course)
    {
        $values = Helpers::dbAddAudit(request()->all());

        Helpers::flash($course->update($values), 'transcript options', 'updated');

        return redirect()->back();
    }

    /**
     * Process the scheduling variables.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public static function storeSchedulingOptions(Course $course)
    {
        $values = Helpers::dbAddAudit(request()->all());

        if (! $course->gradeLevels()->sync($values['grade_levels'])) {
            Helpers::flashAlert(
                'danger',
                'Could not save grade levels. Please try again.',
                'fa fa-info-circle mr-1');

            return redirect()->back();
        }

        unset($values['grade_levels']);
        Helpers::flash($course->update($values), 'scheduling options', 'update');

        return redirect()->back();
    }

    /**
     * Store the course required materials.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeRequiredMaterials(Course $course)
    {
        $values = request()->all();
        $course = Helpers::dbAddAudit($course);

        $course->required_materials = $values['materials'];
        Helpers::flash($course->save(), 'course required materials', 'updated');

        return redirect()->back();
    }

    /**
     * Display the updated form.
     *
     * @param Course $course
     * @return Factory|View
     */
    public function update(Course $course)
    {
        $course_types = CourseType::getDropdown();
        $transcript_types = CourseTranscriptType::getDropdown();
        $grade_scales = GradeScale::getDropdown();
        $departments = Department::getDropdown();
        $years = Year::getDropdown();

        return view('course.update', compact(
            'course',
            'course_types',
            'transcript_types',
            'grade_scales',
            'departments',
            'years'
        ));
    }

    /**
     * Update a course's basic information.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeUpdate(Course $course)
    {
        $values = request()->all();
        $values['short_name'] = strtoupper($values['short_name']);
        $course = Helpers::dbAddAudit($course);
        Helpers::flash($course->update($values), 'course', 'updated');

        return redirect()->to('course/index');
    }

    /**
     * Update a course's basic information.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function storeUpdateShow(Course $course)
    {
        $values = request()->all();
        $values['short_name'] = strtoupper($values['short_name']);
        $course = Helpers::dbAddAudit($course);
        Helpers::flash($course->update($values), 'course', 'updated');

        return redirect()->back();
    }
}
