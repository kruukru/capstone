<?php

use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holiday = [
            ['name' => 'All Saints Day', 'date' => "2017-11-01", 'yearly' => 1],
            ['name' => 'All Saints Day', 'date' => "2017-12-25", 'yearly' => 1],
            ['name' => 'Special (non-working) Day', 'date' => "2017-10-31", 'yearly' => 0],
        ];
        DB::table('holidaytbl')->insert($holiday);
    }
}
