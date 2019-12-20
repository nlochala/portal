<?php

namespace App\Events;

use App\BehaviorAssessment;
use App\CourseClass;
use App\Quarter;
use App\Student;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BehaviorGraded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Quarter $quarter;
    public CourseClass $class;
    public Student $student;

    /**
     * Create a new event instance.
     * @param Quarter $quarter
     * @param CourseClass $class
     * @param Student $student
     */
    public function __construct(Quarter $quarter, CourseClass $class, Student $student)
    {
        $this->quarter = $quarter;
        $this->class = $class;
        $this->student = $student;
    }
}
