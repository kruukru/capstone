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
            ['name' => 'Personality', 'instruction' => 'The following are partly completed sentences. Read each one and finish it by writing the first thing that comes to your mind. Work as quickly as you can.', 'maxquestion' => 5, 'timealloted' => 5],
        ];
        DB::table('testtbl')->insert($test);

        $testquestion = [
            ['testid' => 1, 'questionid' => 1],
            ['testid' => 1, 'questionid' => 2],
            ['testid' => 1, 'questionid' => 3],
            ['testid' => 1, 'questionid' => 4],
            ['testid' => 1, 'questionid' => 5],
            ['testid' => 2, 'questionid' => 6],
            ['testid' => 2, 'questionid' => 7],
            ['testid' => 2, 'questionid' => 8],
            ['testid' => 2, 'questionid' => 9],
            ['testid' => 2, 'questionid' => 10],
        ];
        DB::table('testquestiontbl')->insert($testquestion);
    }
}
