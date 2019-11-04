<?php

namespace App\Console\Commands;

use App\Quarter;
use App\Student;
use App\GradeLevel;
use App\CourseClass;
use App\AttendanceDay;
use App\AttendanceClass;
use App\Helpers\Helpers;
use App\GradeQuarterAverage;
use App\GradeBehaviorQuarter;
use App\ReportCardPercentage;
use Illuminate\Console\Command;
use App\ReportCardPercentageClass;

class CalculateReportCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:calculate-report-cards 
    {grade-level-id* : The ID/s of the grade-levels you wish to process. (You can pass multiple IDs separated by a space.)}
    {--quarter= : What is the quarter_id to process?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate report card values based on attendance and gradebooks.';

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
        if ($grade_levels = GradeLevel::find($this->argument('grade-level-id'))) {
            if ($quarter = Quarter::find($this->option('quarter'))) {
                $this->line('---------------------');
                $this->line('Selected Quarter');
                $this->info($quarter->name.' - '.$quarter->year->name);
                $this->line('---------------------');
                $this->line('Selected Grade Levels');
                foreach ($grade_levels as $grade_level) {
                    $this->info('- '.$grade_level->name);
                }
                if ($this->confirm('Do you wish to process these grade levels for '.$quarter->name.'?')) {
                    // Display the grade levels to process, then ask for confirmation.
                    $count = 0;
                    foreach ($grade_levels as $grade_level) {
                        $students = Student::grade($grade_level->short_name);
                        $count += $students->count();
                    }

                    $bar = $this->output->createProgressBar($count);
                    $bar->start();

                    foreach ($grade_levels as $grade_level) {
                        $students = Student::grade($grade_level->short_name)->get();

                        foreach ($students as $student) {
                            //////////////////////////////////////////////////////////////////////////////////////
                            //////////////////////////////////////////////////////////////////////////////////////
                            //////////////////////////////////////////////////////////////////////////////////////
                            $relationship = $quarter->getClassRelationship();
                            $classes = CourseClass::isStudent($student->id, $relationship)->with('course')->get();
                            $grades = GradeQuarterAverage::isQuarter($quarter->id)->isStudent($student->id)->get();
                            $behavior = GradeBehaviorQuarter::where('student_id', $student->id)
                                ->where('quarter_id', $quarter->id)->first();

                            if ($existing_report_card = ReportCardPercentage::where('student_id', $student->id)->where('quarter_id', $quarter->id)->first()) {
                                $card = $existing_report_card;
                            } else {
                                $card = new ReportCardPercentage();
                            }
                            $card = Helpers::dbAddAudit($card);
                            $card->student_id = $student->id;
                            $card->quarter_id = $quarter->id;
                            $card->grade_behavior_quarter_id = $behavior ? $behavior->id : null;

                            /// Attendance
                            $card->days_absent = AttendanceDay::isQuarter($quarter->id)->isStudent($student->id)->absent()->count();
                            $card->days_present = AttendanceDay::isQuarter($quarter->id)->isStudent($student->id)->present()->count();
                            $card->days_tardy = AttendanceClass::isQuarter($quarter->id)->isStudent($student->id)->unexcusedTardy()->count();
                            $card->save();

                            foreach ($classes as $class) {
                                if ($grade = $grades->where('class_id', $class->id)->first()) {
                                    $grade = $grade->percentage.'% '.$grade->grade_name;
                                } else {
                                    $grade = '--';
                                }

                                $existing_class_report = ReportCardPercentageClass::where('report_card_percentage_id', $card->id)
                                    ->where('class_id', $class->id)->first();
                                $class_card = $existing_class_report ?: new ReportCardPercentageClass();
                                $class_card = Helpers::dbAddAudit($class_card);
                                $class_card->report_card_percentage_id = $card->id;
                                $class_card->class_id = $class->id;
                                $class_card->grade = $grade;
                                $class_card->save();
                            }
                            //////////////////////////////////////////////////////////////////////////////////////
                            //////////////////////////////////////////////////////////////////////////////////////
                            //////////////////////////////////////////////////////////////////////////////////////
                            $bar->advance();
                        }
                    }

                    $bar->finish();
                }
            }
        }
    }
}
