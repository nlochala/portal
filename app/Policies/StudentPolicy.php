<?php

namespace App\Policies;

use App\Student;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->can('permissions')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any students.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function view(User $user, Student $student)
    {
        return (is_guardian() && $student->isMyGuardian($user->person->guardian->id))
            || (is_student() && $student->person->id === $user->person->id);
    }

    /**
     * Determine whether the user can create students.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function update(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function delete(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can restore the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function restore(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param User $user
     * @param Student $student
     * @return mixed
     */
    public function forceDelete(User $user, Student $student)
    {
        //
    }
}
