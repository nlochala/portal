<?php


namespace App\Helpers;


use App\AssignmentType;
use App\AttendanceClass;
use App\AttendanceDay;
use App\Course;
use App\CourseClass;
use App\GradeLevel;
use App\Person;
use App\Quarter;
use App\Student;
use Carbon\Carbon;

class DatabaseHelpers extends Helpers
{
    /**
     * Remove duplicate enrollments.
     * Sometimes, a student will be enrolled in the same class multiple times.
     * Not sure how that happens, but this method will clean that up.
     *
     * @param null $class_id
     * @param bool $audit_only
     * @return array
     */
    public static function checkDuplicateEnrollment($class_id = null, $audit_only = true)
    {
        $return_array = [];
        $relationship_array = ['q1Students', 'q2Students', 'q3Students', 'q4Students'];

        if ($class_id) {
            $classes = CourseClass::where('id', $class_id)->get();
        } else {
            $classes = CourseClass::with($relationship_array)->get();
        }

        foreach ($classes as $class) {
            foreach ($relationship_array as $relationship) {
                $enrollment = $class->$relationship;
                if ($enrollment->count() !== $enrollment->unique()->count()) {
                    if ($audit_only) {
                        $return_array['INFO'] = 'You are running in audit only. If you want to make changes, run with false. checkDuplicateEnrollment(xxx, false)';
                        $return_array[$class->fullName()][] = $relationship;
                    } else {
                        $unique_ids = $enrollment->unique()->pluck('id')->toArray();
                        $class->$relationship()->sync([]);
                        $class->$relationship()->sync($unique_ids);
                    }
                }
            }
        }

        return $return_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Clean up people's names.
     *
     * @param Person|null $person
     */
    public static function checkPersonName(Person $person = null)
    {
        if (!$person) {
            $persons = Person::all();
        } else {
            $persons = Person::where('id', $person->id)->get();
        }

        foreach ($persons as $person) {
            $person->family_name = self::fixStringForName($person->family_name);
            $person->given_name = self::fixStringForName($person->given_name);
            $person->preferred_name = self::fixStringForName($person->preferred_name);

            $person->save();
        }
    }

    /**
     * Use with the checkPersonName method. Cleanup the person's name.
     *
     * @param $string
     * @return string
     */
    public static function fixStringForName($string)
    {
        $string = strtolower($string);
        $string = str_replace(',', '', $string);

        if (substr_count($string, ' ')) {
            $string = implode(' ', array_map('ucfirst', explode(' ', $string)));
        }

        if (substr_count($string, '-')) {
            $string = implode('-', array_map('ucfirst', explode('-', $string)));
        }

        $string = ucwords($string);

        return $string;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Check and delete any duplicate attendance.
     *
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public static function checkDuplicateAttendance($start_date = 'Y-m-d', $end_date = 'Y-m-d')
    {
        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);
        $delete_array = [];

        while ($start <= $end) {
            $students = Student::current()->get();
            foreach ($students as $student) {
                $attendance_list = AttendanceClass::where('date', $start->format('Y-m-d'))
                    ->where('student_id', $student->id)
                    ->get();
                if ($attendance_list->count() > 1) {
                    $x = 0;
                    foreach ($attendance_list as $attendance) {
                        if ($x === 0) {
                            $x++;
                            continue;
                        }
                        $delete_array[] = $attendance->id;
                        $attendance->delete();
                    }
                }
            }

            $start->addDay();
        }

        return $delete_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Confirm that a class doesn't have duplicated assignmentTypes
     *
     * @return array
     */
    public static function checkAssignmentTypeCount()
    {
        $check_array = [];
        $classes = CourseClass::active()->with('assignmentTypes')->get();
        foreach ($classes as $class) {
            if ($class->assignmentTypes->count() > 4) {
                $check_array[] = $class->id;
            }
        }

        return $check_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Check and make sure all assignment_types have some assignments assigned.
     *
     * @param Quarter $quarter
     * @return array
     */
    public static function checkAssignmentCountPerType(Quarter $quarter)
    {
        $relationship = $quarter->getClassRelationship();

        $classes = CourseClass::active()->isPercentageBased()->with($relationship)->get();
        $class_array = [];

        foreach ($classes as $class) {
            if ($class->$relationship->count() !== 0) {
                foreach ($class->assignmentTypes as $type) {
                    if ($type->assignments()->where('quarter_id', $quarter->id)->count() === 0) {
                        $class_array[$class->fullName()] = $type->name;
                    }
                }
            }
        }

        return $class_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set the assignment types for all specific classes in a grade level.
     *
     * @param array $grade_levels
     * @param string $types
     * @param bool $is_mandarin
     * @return array|int
     */
    public static function prepopulateAssignmentTypes(array $grade_levels, $types = 'hs_types or ms_types', $is_mandarin = false)
    {
        $names = [];
        if ($types === 'hs_types') {
            $types = [
                [
                    'name' => 'Tests and Projects',
                    'description' => 'Tests and Projects',
                    'weight' => '40',
                ],
                [
                    'name' => 'Homework',
                    'description' => 'Homework',
                    'weight' => '20',
                ],
                [
                    'name' => 'Participation and Class Work',
                    'description' => 'Participation and Class Work',
                    'weight' => '15',
                ],
                [
                    'name' => 'Quizzes',
                    'description' => 'Quizzes',
                    'weight' => '25',
                ],
            ];
        } elseif ($types === 'ms_types') {
            $types = [
                [
                    'name' => 'Tests and Projects',
                    'description' => 'Tests and Projects',
                    'weight' => '45',
                ],
                [
                    'name' => 'Homework',
                    'description' => 'Homework',
                    'weight' => '10',
                ],
                [
                    'name' => 'Participation and Class Work',
                    'description' => 'Participation and Class Work',
                    'weight' => '20',
                ],
                [
                    'name' => 'Quizzes',
                    'description' => 'Quizzes',
                    'weight' => '25',
                ],
            ];
        } elseif ($types === 'el_types') {
            $types = [
                [
                    'name' => 'Tests and Projects',
                    'description' => 'Tests and Projects',
                    'weight' => '50',
                ],
                [
                    'name' => 'Homework',
                    'description' => 'Homework',
                    'weight' => '10',
                ],
                [
                    'name' => 'Participation',
                    'description' => 'Participation',
                    'weight' => '10',
                ],
                [
                    'name' => 'Quizzes',
                    'description' => 'Quizzes',
                    'weight' => '30',
                ],
            ];
        } else {
            $types = [];
        }

        foreach ($grade_levels as $grade) {
            $grade_model = GradeLevel::current()->grade($grade)->first();
            if ($is_mandarin) {
                $courses = Course::with('classes')->active()->isMandarin()->gradeLevel($grade_model->id)->get();
            } else {
                $courses = Course::with('classes')->active()->gradeLevel($grade_model->id)->get();
            }

            foreach ($courses as $course) {
                foreach ($course->classes as $class) {
                    if ($class->assignmentTypes->isEmpty()) {
                        $names[] = $class->course->name . ' - ' . $class->name;
                        foreach ($types as $type) {
                            $type['class_id'] = $class->id;
                            $type['user_created_id'] = 1;
                            $type['user_created_ip'] = '127.0.0.1';
                            $type['is_protected'] = true;
                            $assignment_type = AssignmentType::create($type);
                        }
                    }
                }
            }
        }

        return $names;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show missing attendance for a given quarter.
     *
     * @param Quarter $quarter
     * @return array
     */
    public static function reportMissingAttendance(Quarter $quarter)
    {
        ini_set('memory_limit', '4G');
        $days = $quarter->days()->isSchoolDay()->get();
        $return_array = [];

        foreach ($days as $day) {
            if (Carbon::parse($day->date)->isFuture() || $day->date === now()->format('Y-m-d')) {
                continue;
            }
            $students = Student::current()->activeOn(Carbon::parse($day->date))->get();
            foreach ($students as $student) {
                if (AttendanceDay::isStudent($student->id)->date($day->date)->count() === 0) {
                    $return_array[$student->id][] = $day->date;
                }
            }
        }

        return $return_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Change the entire school populations' attendance.
     *
     * @param $start_date
     * @param $end_date
     * @param $default_status
     */
    public static function batchPresentAttendance($start_date, $end_date, $default_status)
    {
        $start_date = Carbon::parse($start_date);
        $date = $start_date;
        $end_date = Carbon::parse($end_date);

        while ($date <= $end_date) {
            if ($date->isWeekend()) {
                $date->addDay();
                continue;
            }

            $students = Student::current()->activeOn($date)->get();
            foreach ($students as $student) {
                if ($attendance = AttendanceDay::date($date->format('Y-m-d'))->isStudent($student->id)->with('type')->first()) {
                    continue;
                }

                $values['student_id'] = $student->id;
                $values['date'] = $date->format('Y-m-d');
                $values['attendance_type_id'] = $default_status;
                $values['quarter_id'] = Quarter::getQuarter($date)->id;
                $values = DatabaseHelpers::dbAddAudit($values);

                AttendanceDay::create($values);
            }

            $date->addDay();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Set the DB Audit Fields.
     *
     * @param $model
     *
     * @return mixed
     */
    public static function dbAddAudit($model)
    {
        auth()->user() ? $user_id = auth()->user()->id : $user_id = 1;

        if (is_array($model)) {
            $model['user_created_id'] = $user_id;
            $model['user_created_ip'] = static::getUserIp();

            return $model;
        }

        if ($model->exists) {
            $model->user_updated_id = $user_id;
            $model->user_updated_ip = static::getUserIp();
        } else {
            $model->user_created_id = $user_id;
            $model->user_created_ip = static::getUserIp();
        }

        return $model;
    }

    /**
     * Return the user's IP address.
     *
     * @return string
     */
    public static function getUserIp()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)
            && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
        ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])
                && !empty($_SERVER['REMOTE_ADDR'])
            ) {
                return $_SERVER['REMOTE_ADDR'];
            }
        }

        return '127.0.0.1';
    }
}
