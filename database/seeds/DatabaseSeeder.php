<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(AddressTypesTableSeeder::class);
        $this->call(FileExtensionsTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(PhoneTypesTableSeeder::class);
        $this->call(VisaTypesTableSeeder::class);
        $this->call(EthnicitiesTableSeeder::class);
        $this->call(VisaEntryTableSeeder::class);
        $this->call(OfficialDocumentTypesTableSeeder::class);
        $this->call(PersonTypesTableSeeder::class);
        $this->call(EmployeeBonusTypesTableSeeder::class);
        $this->call(EmployeeClassificationsTableSeeder::class);
        $this->call(EmployeeStatusesTableSeeder::class);
        $this->call(PositionTypesTableSeeder::class);
        $this->call(SchoolAreasTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
        $this->call(YearsTableSeeder::class);
    }
}
