<?php

namespace App\Console\Commands;

use App\Quarter;
use App\CourseClass;
use Illuminate\Console\Command;
use App\Events\AssignmentGraded;

class CalculateQuarterGrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:calculate-quarter-grade
    {--quarter= : What is the quarter_id to process?}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loop through all students and re-calculate their quarter grade.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '4G');

        $class = '';
        $student = '';
        if ($this->options('quarter')) {
            $quarter = Quarter::find($this->option('quarter'));
        } else {
            $quarter = Quarter::now();
        }
        $relationship = $quarter->getClassRelationship();

        $classes = CourseClass::active()->isPercentageBased()->with($relationship)->get();

        foreach ($classes as $class) {
            foreach ($class->$relationship as $student) {
                event(new AssignmentGraded($student, $class, $quarter));
            }
        }
    }
}
