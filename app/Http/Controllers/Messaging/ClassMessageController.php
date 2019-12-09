<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\Employee;
use App\Guardian;
use App\Helpers\DatabaseHelpers;
use App\Helpers\Helpers;
use App\Helpers\ViewHelpers;
use App\Notifications\ParentMessageSent;
use App\ParentMessage;
use App\Quarter;
use App\Student;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassMessageController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('can:employee-only');
    }

    /**
     * Send a new message form.
     *
     * @param CourseClass $class
     * @return Factory|View
     */
    public function dashboard(CourseClass $class)
    {
        $relationship = Quarter::now()->getClassRelationship();
        $class->load($relationship.'.person');
        $messages = ParentMessage::recipient(auth()->user()->person->employee)->isClass($class->id)->get();

        foreach (auth()->user()->unreadNotifications as $notification) {
            if ($notification->type === 'App\\Notifications\\ParentMessageSent') {
                $notification->markAsRead();
            }
        }

        $student_dropdown = [];

        foreach ($class->$relationship as $student) {
            $student_dropdown[$student->id] = $student->person->fullName();
        }

        return view('message.dashboard', compact('student_dropdown','messages','class'));
    }

    /**
     * Show all sent messages by the guardian.
     *
     * @param CourseClass $class
     * @return Factory|View
     */
    public function sent(CourseClass $class)
    {
        $messages = ParentMessage::authorModel('employee')->isClass($class->id)->get();

        return view('message.sent_message', compact('guardian', 'messages'));
    }

    /**
     * Save the message to teachers.
     *
     * @param CourseClass $class
     * @return RedirectResponse
     */
    public function saveMessage(CourseClass $class)
    {
        $values = DatabaseHelpers::dbAddAudit(request()->all());
        $relationship = Quarter::now()->getClassRelationship();
        $class->load($relationship.'.person');

        if ($values['all_students'] === '1') {
            foreach ($class->$relationship as $student) {
                if ($student->family) {
                    foreach ($student->family->guardians as $guardian) {
                        $this->sendMessage($guardian, auth()->user()->person->employee, $class, $values);
                    }
                }
            }
        } else {
            foreach($values['student_id'] as $student_id) {
                $student = Student::find($student_id);
                if ($student->family) {
                    foreach ($student->family->guardians as $guardian) {
                        $this->sendMessage($guardian, auth()->user()->person->employee, $class, $values);
                    }
                }
            }
        }

       ViewHelpers::flash(true, 'messages', 'sent');
        return redirect()->back();
    }

    /**
     * Send the given message.
     *
     * @param Guardian $guardian
     * @param Employee $employee
     * @param CourseClass $class
     * @param $values
     * @return void
     */
    public function sendMessage(Guardian $guardian, Employee $employee, CourseClass $class, $values)
    {
        $message = DatabaseHelpers::dbAddAudit(new ParentMessage());
        $message->from_model = 'employee';
        $message->from_id = $employee->id;
        $message->to_model = 'guardian';
        $message->to_id = $guardian->id;
        $message->class_id = $class->id;
        $message->subject = $values['subject'];
        $message->body = $values['message_body'];

        if ($message->save()) {
            if ($user = $guardian->user) {
                $user->notify( new ParentMessageSent($message));
            }
        }

        return $message->save();
    }
}
