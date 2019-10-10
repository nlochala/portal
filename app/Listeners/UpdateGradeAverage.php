<?php

namespace App\Listeners;

use App\GradeAverage;
use App\Helpers\Helpers;
use App\GradeQuarterAverage;
use App\Events\AssignmentGraded;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateGradeAverage implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AssignmentGraded $event
     * @return void
     */
    public function handle(AssignmentGraded $event)
    {
        $grade_array = [];
        $student_grade_array = [];
        $type_is_empty = false;

        $assignment_types = $event->class->assignmentTypes;

        foreach ($assignment_types as $type) {
            $grade_array[$type->id] = [
                'weight' => $type->weight,
                'max_points' => 0,
                'points_earned' => 0,
            ];
            $assignments = $type->assignments()->quarter($event->quarter->id)->get();

            foreach ($assignments as $assignment) {
                if ($grade = $assignment->grades()->isStudent($event->student->id)->first()) {
                    if ($grade === null || $grade->is_excused || $grade->points_earned === null) {
                        continue;
                    }

                    $grade_array[$type->id]['max_points'] += $assignment->max_points;
                    $grade_array[$type->id]['points_earned'] += $grade->points_earned;
                }
            }
        }

        foreach ($grade_array as $assignment_type_id => $item) {
            // An assignment type has no assignments yet for it. In that case, we will assume full
            // credit for that type. Otherwise, if we calculate it the best case outcome is the overall
            // cumuluative grade will be 100% minus the weight of the missing type.
            if (empty($item['max_points'])) {
                $student_grade_array[] = ($item['weight'] / 100);
            } else {
                $student_grade_array[] = ($item['points_earned'] / $item['max_points']) * ($item['weight'] / 100);
            }



            if ($average = GradeAverage::isStudent($event->student->id)->isQuarter($event->quarter->id)->isClass($event->class->id)->isAssignmentType($assignment_type_id)->first()) {
                $average = Helpers::dbAddAudit($average);
                $average->max_points = $item['max_points'];
                $average->points_earned = $item['points_earned'];
                $average->save();

                continue;
            }

            $average = new GradeAverage();
            $average = Helpers::dbAddAudit($average);
            $average->quarter_id = $event->quarter->id;
            $average->student_id = $event->student->id;
            $average->class_id = $event->class->id;
            $average->assignment_type_id = $assignment_type_id;
            $average->grade_scale_id = $event->class->course->grade_scale_id;
            $average->max_points = $item['max_points'];
            $average->points_earned = $item['points_earned'];
            $average->save();
        }

        //////////////////////////////////////////////////////////////////

        if (empty($student_grade_array)) {
            return;
        }

        $grade_scale = $event->class->course->gradeScale;
        $percentage = array_sum($student_grade_array) * 100;
        $name = null;

        if ($grade_scale->is_percentage_based) {
            $x = 0;
            foreach ($grade_scale->items->sortByDesc('from') as $item) {
                if (round($percentage) >= $item->from && $x === 0) {
                    $name = $item->result;
                }

                if (round($percentage) <= $item->from && round($percentage) >= $item->to) {
                    $name = $item->result;
                }

                $x++;
            }
        }

        if ($quarter_average = GradeQuarterAverage::isStudent($event->student->id)->isQuarter($event->quarter->id)->isClass($event->class->id)->first()) {
            $quarter_average = Helpers::dbAddAudit($quarter_average);
            $quarter_average->percentage = round($percentage, 3);
            $quarter_average->grade_name = $name;
            $quarter_average->save();

            return;
        }

        $quarter_average = new GradeQuarterAverage();
        $quarter_average = Helpers::dbAddAudit($quarter_average);
        $quarter_average->percentage = round($percentage, 3);
        $quarter_average->grade_name = $name;
        $quarter_average->quarter_id = $event->quarter->id;
        $quarter_average->student_id = $event->student->id;
        $quarter_average->class_id = $event->class->id;
        $quarter_average->save();
    }
}
