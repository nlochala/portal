<?php

namespace Metrogistics\AzureSocialite;

use App\AdGroup;
use App\Role;
use App\Employee;
use App\Guardian;
use App\Student;
use App\Helpers\Helpers;
use App\Person;
use App\User as AppUser;

class UserFactory
{
    protected $config;
    protected static $user_callback;
    protected $user_class;
    protected $user_map;
    protected $id_field;

    public function __construct()
    {
        $this->config = config('azure-oath');
        $this->user_class = config('azure-oath.user_class');
        $this->user_map = config('azure-oath.user_map');
        $this->id_field = config('azure-oath.user_id_field');
    }

    public function updateAzureUser($azure_user, $auth_user)
    {
        $this->checkUser($azure_user);

        $id_field = $this->id_field;
        $auth_user->$id_field = $azure_user->id;

        foreach ($this->user_map as $azure_field => $user_field) {
            $auth_user->$user_field = $azure_user->$azure_field;
        }

        $auth_user->username = $this->getUsernameFromEmail($azure_user->email);

        $callback = static::$user_callback;

        if ($callback && is_callable($callback)) {
            $callback($auth_user);
        }

        !$auth_user->isDirty() ?: $auth_user->update();

        $this->attachAdGroups($azure_user->user['groups'], $auth_user);

        return $auth_user;
    }

    public function convertAzureUser($azure_user)
    {
        $user_method = $this->checkUser($azure_user);

        $id_field = $this->id_field;
        $new_user = new $this->user_class;
        $new_user->$id_field = $azure_user->id;

        foreach ($this->user_map as $azure_field => $user_field) {
            $new_user->$user_field = $azure_user->$azure_field;
        }

        $new_user->username = $this->getUsernameFromEmail($azure_user->email);

        $callback = static::$user_callback;

        if ($callback && is_callable($callback)) {
            $callback($new_user);
        }

        if ($user_method === 'newGuardian') {
            $guardian = Guardian::where('username',$new_user->email)->first();
            $person = $guardian->person;
        }
        if ($user_method === 'newStudent') {
            $student = Student::where('username',$new_user->email)->first();
            $person = $student->person;
        }
        if ($user_method === 'newEmployee') {
            $person = Person::where('email_school', $new_user->email)->get();
            $person->isEmpty() ? $person = $this->newPerson($new_user) : $person = $person->first();
        }

        $new_user->person_id = $person->id;
        $new_user->save();

        // User is ready to be used: $new_user;
        $groups = $this->attachAdGroups($azure_user->user['groups'], $new_user);
        $this->$user_method($new_user, $person);

        return $new_user;
    }

    public static function userCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception("Must provide a callable.");
        }

        static::$user_callback = $callback;
    }

    public function getUsernameFromEmail($email)
    {
        if (!empty($email)) {
            return explode('@', $email)[0];
        }
    }

    public function attachAdGroups(array $groups, $user)
    {
        $ids_array = [];
        $roles_array = [];

        foreach ($groups as $group) {
            $group_obj = AdGroup::where('azure_id', $group['id'])->first();

            if (empty($group_obj)) {
                $group_obj = new AdGroup();
            }

            $group_obj->azure_id = $group['id'];
            array_key_exists('mail', $group) ? $group_obj->email = $group['mail'] : $group_obj->email = null;
            $group_obj->name = $group['displayName'];
            $group_obj = Helpers::dbAddAudit($group_obj);

            $group_obj->exists ? $group_obj->update() : $group_obj->save();

            if ($role = $group_obj->role) {
                $roles_array[] = $role->id;
            }elseif (preg_match('/^All Students/', $group_obj->name)) {
                $role = Role::where('name','student')->first();
                if ($role->ad_group_id !== $group_obj->id) {
                    $role->ad_group_id = $group_obj->id;
                    $role->save();
                }
                $roles_array[] = $role->id;
            }elseif (preg_match('/^All Guardians/', $group_obj->name)) {
                $role = Role::where('name','guardian')->first();
                if ($role->ad_group_id !== $group_obj->id) {
                    $role->ad_group_id = $group_obj->id;
                    $role->save();
                }
                $roles_array[] = $role->id;
            }elseif (preg_match('/^All Staff/', $group_obj->name)) {
                $role = Role::where('name','employee')->first();
                if ($role->ad_group_id !== $group_obj->id) {
                    $role->ad_group_id = $group_obj->id;
                    $role->save();
                }
                $roles_array[] = $role->id;
            }elseif (preg_match('/^portal-/', $group_obj->name)) {
                if ($role = Role::where('name',$group_obj->name)->first()){
                    if ($role->ad_group_id !== $group_obj->id) {
                        $role->ad_group_id = $group_obj->id;
                        $role->save();
                    }

                    $roles_array[] = $role->id;
                }else{
                    $role = new Role();
                    $role->name = $group_obj->name;
                    $role->ad_group_id = $group_obj->id;
                    $role->save();

                    $roles_array[] = $role->id;
                }
            }

            $ids_array[] = $group_obj->id;
        }

        $user->adGroups()->sync($ids_array);
        $user->roles()->sync($roles_array);

        return;
    }

    public function newPerson(AppUser $user)
    {
        $person = new Person();
        $person->email_school = $user->email;
        $person->family_name ?: $person->family_name = $user->family_name;
        if (!$person->given_name) {
            $person->given_name = $user->given_name;
            $person->preferred_name = $user->given_name;
        }
        $person = Helpers::dbAddAudit($person);
        $person->save();

        return $person;
    }

    public function newStudent(AppUser $user, Person $person)
    {
        // Just in case there are things we want to do.
        return;
    }

    public function newGuardian(AppUser $user, Person $person)
    {
        // Just in case there are things we want to do.
        return;
    }

    public function newEmployee(AppUser $user, Person $person)
    {
        if ($employee = Employee::where('person_id', $person->id)->first()) {
            return $employee;
        }

        $employee = new Employee();
        $employee->person_id = $person->id;
        $employee = Helpers::dbAddAudit($employee);
        $employee->save();

        return $employee;
    }

    public function checkUser($azure_user)
    {
        foreach ($azure_user->user['groups'] as $key => $group) {
            if (preg_match('/^' . env('STUDENT_GROUP_PREFIX') . '/', $key)) {
                return 'newStudent';
            }

            if (preg_match('/^' . env('GUARDIAN_GROUP_PREFIX') . '/', $key)) {
                return 'newGuardian';
            }

            if (preg_match('/^' . env('EMPLOYEE_GROUP_PREFIX') . '/', $key)) {
                return 'newEmployee';
            }
        }

        abort(403, 'You must belong to a specific AD group to gain access to the portal. 
                                    Please contact the IT Department.');
    }
}
