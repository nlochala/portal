<?php

use App\Guardian;
use App\Person;
use Illuminate\Database\Seeder;

class GuardianFakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        //Guardian
        DB::table('guardians')->truncate();
        factory(Person::class, 1300)->create()
            ->each(static function ($person) {
                factory(Guardian::class)
                    ->create([
                        'person_id' => $person->id,
                        'family_id' => null,
                    ]);
            });

        Schema::enableForeignKeyConstraints();
    }
}
