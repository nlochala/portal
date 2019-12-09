<?php


namespace App\Helpers;


use App\AttendanceClass;
use App\Quarter;
use App\Student;
use Carbon\Carbon;

class ReportHelpers extends Helpers
{
    /**
     * Generate a report on how many parents/students have logged into the
     * parent portal from a given set of grade levels.
     *
     * @return array
     */
    public static function getLoginPercentages()
    {
        $return_array =
            [
                'Secondary' => ['student total' => 0, 'student logins' => 0, 'guardian total' => 0, 'guardian logins' => 0],
                'Elementary' => ['student total' => 0, 'student logins' => 0, 'guardian total' => 0, 'guardian logins' => 0],
            ];
        $grade_levels =
            [
                'Secondary' => ['06', '07', '08', '09', '10', '11', '12'],
                'Elementary' => ['03', '04', '05'],
            ];
        foreach ($grade_levels as $name => $grades) {
            $student_total = 0;
            $student_logins = 0;
            $guardian_total = 0;
            $guardian_logins = 0;
            foreach($grades as $grade) {
                $students = Student::current()->grade($grade)->with('person.user')->get();
                $return_array[$name]['student total'] += $students->count();
                foreach ($students as $student) {
                    if ($student->person->user) {
                        $student_logins++;
                    }
                }

                foreach ($students as $student) {
                    if ($student->family) {
                        $guardians = $student->family->guardians;
                        $return_array[$name]['guardian total'] += $guardians->count();
                        foreach ($guardians as $guardian) {
                            if ($guardian->person->user) {
                                $guardian_logins++;
                            }
                        }
                    }
                }
            }

            $return_array[$name]['student logins'] = $student_logins;
            $return_array[$name]['guardian logins'] = $guardian_logins;

            $return_array[$name]['percentage'] =
                round( ($return_array[$name]['student logins'] / $return_array[$name]['student total'])*100).'%';
            $return_array[$name]['percentage'] =
                round( ($return_array[$name]['guardian logins'] / $return_array[$name]['guardian total'])*100).'%';
        }

        return $return_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get a quick nationality breakdown.
     *
     * @return array
     */
    public static function getEthnicBreakdown()
    {
        $nationality_array['OTHER'] = 0;
        $students = Student::current()->with('person.nationality')->get();
        foreach ($students as $student) {
            if (!$student->person->nationality) {
                $nationality_array['OTHER'] = $nationality_array['OTHER'] + 1;
                continue;
            }
            if (isset($nationality_array[$student->person->nationality->name])) {
                $nationality_array[$student->person->nationality->name] = $nationality_array[$student->person->nationality->name] + 1;
                continue;
            }

            $nationality_array[$student->person->nationality->name] = 1;
        }

        return $nationality_array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Show those students that are awarded honorRoll.
     *
     * @param Quarter $quarter
     * @return array
     */
    public static function getHonorRoll(Quarter $quarter)
    {
        $all_as_array = [];
        $all_ab_array = [];

        $grade_levels = [
            '06',
            '07',
            '08',
            '09',
            '10',
            '11',
            '12',
        ];

        foreach ($grade_levels as $short_name) {
            $students = Student::current()->with('gradeQuarterAverages')->grade($short_name)->get();
            foreach ($students as $student) {
                $grades = $student->gradeQuarterAverages()->where('quarter_id', $quarter->id)->get();
                if ($grades->where('percentage', '<', 90)->count() === 0) {
                    $all_as_array[$short_name][] = $student->getFormalNameAttribute(false);
                } elseif ($grades->where('percentage', '<', 80)->count() === 0) {
                    $all_ab_array[$short_name][] = $student->getFormalNameAttribute(false);
                }
            }
        }

        return ['All A\'s' => $all_as_array, 'All A\'s and B\'s' => $all_ab_array];
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return the previous working days for reporting purposes.
     *
     * @param $starting_date
     * @param int $number_of_days
     * @param string $carbon_format
     * @return array
     */
    public static function getPreviousWorkingDays(string $starting_date = 'Y-m-d', $number_of_days = 5, $carbon_format = 'Y-m-d')
    {
        $date_array = [];
        for ($i = ($number_of_days - 1); $i >= 0; $i--) {
            $start_date = Carbon::parse($starting_date);
            $date_array[] = $start_date->subWeekdays($i)->format($carbon_format);
        }

        return $date_array;
    }
}
