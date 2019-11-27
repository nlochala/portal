<?php

namespace App\Http\Controllers;

use App\CourseClass;
use App\Employee;
use App\Guardian;
use App\Helpers\Helpers;
use App\Notifications\ParentMessageSent;
use App\ParentMessage;
use App\Quarter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentMessageController extends Controller
{
    /**
     * Require users to have been authenticated before reaching this page.
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mark a message as read.
     * Due to the ajax request, we have to return a string.
     *
     * @param ParentMessage $message
     * @return string
     */
    public function markRead(ParentMessage $message)
    {
        $user = $message->to->person->user;
        if ($user->person->id === auth()->user()->person->id) {
            $message->is_read = true;
            $message->save();

            return 'true';
        }

        return 'false';
    }

    /**
     * Send a new message form.
     *
     * @return Factory|View
     */
    public function new()
    {
        $guardian = auth()->user()->person->guardian;
        $relationship = Quarter::now()->getClassRelationship();

        $class_dropdown = [];

        if ($guardian->family && !$guardian->family->students->isEmpty()) {
            $students = $guardian->family->students;

            foreach ($students as $student) {
                $classes = CourseClass::isStudent($student->id, $relationship)->active()->get();
                foreach ($classes as $class) {
                    $class_dropdown[$class->id] = $student->gradeLevel->name.' - '.$class->fullName;
                }
            }
        }

        return view('parent_portal.new_message', compact('class_dropdown', 'guardian'));
    }

    /**
     * Show all messages by the guardian.
     *
     * @return Factory|View
     */
    public function all()
    {
        $guardian = auth()->user()->person->guardian;
        $messages = ParentMessage::recipient($guardian)->get();

        return view('parent_portal.all_message', compact('guardian', 'messages'));
    }

    /**
     * Show all sent messages by the guardian.
     *
     * @return Factory|View
     */
    public function sent()
    {
        $guardian = auth()->user()->person->guardian;
        $messages = ParentMessage::author($guardian)->get();
        $messages = $messages->unique(function ($item) {
            return $item->subject.$item->body.$item->createdAt.$item->class_id;
        });

        return view('parent_portal.sent_message', compact('guardian', 'messages'));
    }

    /**
     * Save the message to teachers.
     *
     * @param Guardian|null $guardian
     * @return RedirectResponse
     */
    public function saveMessage(Guardian $guardian = null)
    {
        $guardian = $guardian ?: auth()->user()->person->guardian;
        $values = request()->all();

        foreach ($values['class_id'] as $class_id) {
            $teachers = ['primaryEmployee', 'secondaryEmployee', 'taEmployee'];
            $class = CourseClass::findOrFail($class_id)->load($teachers);
            foreach ($teachers as $teacher) {
                if($employee = $class->$teacher) {
                    $this->sendMessage($guardian, $employee, $class, $values);
                }
            }
        }

        Helpers::flash(true, 'message', 'sent');

        return redirect()->to('g_guardian/guardian');
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
        $employee = Employee::find(1);

        $message = Helpers::dbAddAudit(new ParentMessage());
        $message->to_model = 'employee';
        $message->to_id = $employee->id;
        $message->from_model = 'guardian';
        $message->from_id = $guardian->id;
        $message->class_id = $class->id;
        $message->subject = $values['subject'];
        $message->body = $values['message_body'];

        if ($message->save()) {
            if ($user = $employee->person->user) {
                $user->notify( new ParentMessageSent($message));
            }
        }
    }
}

