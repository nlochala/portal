<?php

namespace Metrogistics\AzureSocialite;

use App\AdGroup;
use App\Employee;
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

        $auth_user = Helpers::dbAddAudit($auth_user);

        if ($auth_user->isDirty()) {
            $auth_user->update();
        }

        $this->attachAdGroups($azure_user->user['groups'], $auth_user);

        return $auth_user;
    }

    public function convertAzureUser($azure_user)
    {
        $id_field = $this->id_field;
        $new_user = new $this->user_class;
        $new_user->$id_field = $azure_user->id;

        foreach ($this->user_map as $azure_field => $user_field) {
            $new_user->$user_field = $azure_user->$azure_field;
        }

        $new_user->username = $this->getUsernameFromEmail($azure_user->email);

        $person = new Person();
        $person->given_name =

        $callback = static::$user_callback;

        if ($callback && is_callable($callback)) {
            $callback($new_user);
        }

        $new_user = Helpers::dbAddAudit($new_user);

        $new_user->save();

        // User is ready to be used: $new_user;

        $student_groups = $this->attachAdGroups($azure_user->user['groups'], $new_user);
        $person = Person::where('email_school',$new_user->email)->get();

        $person->isEmpty() ? $person = $this->newPerson($new_user) : $person = $person->first();

        $new_user->person_id = $person->id;
        $new_user->save();

        empty($student_groups) ? $this->newEmployee($new_user, $person) : $this->newStudent($new_user, $person);

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
        $student_groups = [];

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

            if(preg_match('/^' . env('STUDENT_GROUP_PREFIX') . '/', $group_obj->name)){
                $student_groups[] = $group_obj->name;
            }

            $ids_array[] = $group_obj->id;
        }

        $user->adGroups()->sync($ids_array);
        return $student_groups;
    }

    public function newPerson(AppUser $user)
    {
        $person = new Person();
        $person->email_school = $user->email;
        $person = Helpers::dbAddAudit($person);
        $person->save();

        return $person;
    }

    public function newStudent(AppUser $user, Person $person)
    {

    }

    public function newEmployee(AppUser $user, Person $person)
    {
        $employee = new Employee();
        $employee->person_id = $person->id;
        $employee = Helpers::dbAddAudit($employee);
        $employee->save();

        return $employee;
    }
}
