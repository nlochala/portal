<?php

use App\Helpers\DatabaseHelpers;
use App\Helpers\FileHelpers;
use App\Person;
use App\Employee;
use App\Helpers\Helpers;
use App\User as AppUser;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $employees = FileHelpers::parseCsv('database/seeds/data/employees.csv', true);

        foreach ($employees as $employee) {
            $person = Person::where('email_school', $employee[2])->get();
            $person->isEmpty() ? $person = $this->newPerson($employee) : $person = $person->first();
            $person->employee !== null ?: $this->newEmployee($employee, $person);
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param $employee
     * @return Person|mixed
     */
    public function newPerson($employee)
    {
        $person = new Person();
        $person->email_school = $employee[2];
        $person->family_name = $employee[1];
        $person->given_name = $employee[0];
        $person = DatabaseHelpers::dbAddAudit($person);
        $person->save();

        return $person;
    }

    /**
     * @param array $employee
     * @param Person $person
     * @return Employee|mixed
     */
    public function newEmployee(array $employee, Person $person)
    {
        if ($employee = Employee::where('person_id', $person->id)->first()) {
            return $employee;
        }

        $employee = new Employee();
        $employee->person_id = $person->id;
        $employee = DatabaseHelpers::dbAddAudit($employee);
        $employee->save();

        return $employee;
    }
}
