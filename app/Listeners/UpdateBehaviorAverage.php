<?php

namespace App\Listeners;

use App\BehaviorAssessment;
use App\BehaviorAssessmentAverage;
use App\Events\BehaviorGraded;
use App\Helpers\DatabaseHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBehaviorAverage
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
     * @param  BehaviorGraded  $event
     * @return void
     */
    public function handle(BehaviorGraded $event)
    {
        $event->student->load(['behaviorAssessments' => function ($query) use ($event) {
            $query->isQuarter($event->quarter->id)->isClass($event->class->id);
        }]);

        if ($event->student->behaviorAssessments->isEmpty()) {
            return;
        }

        $average_grade = BehaviorAssessment::calculateAverage($event->student->behaviorAssessments);
        $average = BehaviorAssessmentAverage::isStudent($event->student->id)->isQuarter($event->quarter->id)->isClass($event->class->id)->first();

        if ($average) {
            $average = DatabaseHelpers::dbAddAudit($average);
            $average->grade = $average_grade;
        } else {
            $average = DatabaseHelpers::dbAddAudit(new BehaviorAssessmentAverage());
            $average->class_id = $event->class->id;
            $average->quarter_id = $event->quarter->id;
            $average->student_id = $event->student->id;
            $average->grade = $average_grade;
        }

        return $average->save();
    }
}
