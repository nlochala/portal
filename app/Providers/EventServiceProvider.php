<?php

namespace App\Providers;

use App\Events\AttendanceTaken;
use App\Events\AssignmentGraded;
use App\Events\BehaviorGraded;
use App\Events\SchoolDaysChanged;
use App\Listeners\UpdateBehaviorAverage;
use App\Listeners\UpdateGradeAverage;
use App\Listeners\UpdateSchoolCalendar;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\UpdateDailyAttendance;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AttendanceTaken::class => [
            UpdateDailyAttendance::class,
        ],
        AssignmentGraded::class => [
            UpdateGradeAverage::class,
        ],
        SchoolDaysChanged::class => [
            UpdateSchoolCalendar::class,
        ],
        BehaviorGraded::class => [
            UpdateBehaviorAverage::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
