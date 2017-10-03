<?php

use Illuminate\Database\Seeder;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $violation = [
            ['name' => 'Security guard smoking while on duty', 'severity' => 'Minor Offense'],
            ['name' => 'Security guard reading newspaper, comics and other unofficial reading materials while on duty', 'severity' => 'Minor Offense'],
            ['name' => 'Posted security guard found drunk, drinking intoxicating liquor or found under the                           influence of prohibited drug while on duty', 'severity' => 'Major Offense'],
            ['name' => 'Abandonment of post', 'severity' => 'Grave Offense'],
        ];
        DB::table('violationtbl')->insert($violation);
    }
}
