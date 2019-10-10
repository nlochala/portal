<?php

namespace App\Events;

use App\Quarter;
use App\Student;
use App\CourseClass;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AssignmentGraded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Student
     */
    public $student;

    /**
     * @var CourseClass
     */
    public $class;

    /**
     * @var Quarter
     */
    public $quarter;

    /**
     * Create a new event instance.
     *
     * @param Student $student
     * @param CourseClass $class
     * @param Quarter $quarter
     */
    public function __construct(Student $student, CourseClass $class, Quarter $quarter)
    {
        $this->student = $student;
        $this->class = $class;
        $this->quarter = $quarter;
    }
}
