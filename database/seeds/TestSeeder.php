<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test = [
            ['name' => 'Intelligence', 'instruction' => 'Answer truthfully', 'maxquestion' => 5, 'timealloted' => 5],
            ['name' => 'Personality', 'instruction' => 'Answer as fast as you can', 'maxquestion' => 5, 'timealloted' => 5],
        ];
        DB::table('testtbl')->insert($test);

        $testquestion = [
            ['testid' => 1, 'questionid' => 1],
            ['testid' => 1, 'questionid' => 2],
            ['testid' => 2, 'questionid' => 3],
            ['testid' => 2, 'questionid' => 4],
            ['testid' => 2, 'questionid' => 5],
        ];
        DB::table('testquestiontbl')->insert($testquestion);
    }
}
