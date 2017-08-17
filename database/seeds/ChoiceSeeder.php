<?php

use Illuminate\Database\Seeder;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $choice = [
            ['choiceid' => 1, 'questionid' => 1, 'answer' => 'RA5487', 'iscorrect' => 0],
            ['choiceid' => 2, 'questionid' => 1, 'answer' => 'RA6425', 'iscorrect' => 0],
            ['choiceid' => 3, 'questionid' => 1, 'answer' => 'Constitution', 'iscorrect' => 1],
            ['choiceid' => 4, 'questionid' => 1, 'answer' => 'Human Rights', 'iscorrect' => 0],
            ['choiceid' => 5, 'questionid' => 2, 'answer' => 'Friend', 'iscorrect' => 1],
            ['choiceid' => 6, 'questionid' => 2, 'answer' => 'Loaded', 'iscorrect' => 0],
            ['choiceid' => 7, 'questionid' => 2, 'answer' => 'Exempt Load', 'iscorrect' => 0],
            ['choiceid' => 8, 'questionid' => 2, 'answer' => 'Restricted', 'iscorrect' => 0],
            ['choiceid' => 9, 'questionid' => 3, 'answer' => 'Authoritarian', 'iscorrect' => 0],
            ['choiceid' => 10, 'questionid' => 3, 'answer' => 'Chief Leader', 'iscorrect' => 1],
            ['choiceid' => 11, 'questionid' => 3, 'answer' => 'Persuasive Leadership', 'iscorrect' => 0],
            ['choiceid' => 12, 'questionid' => 3, 'answer' => 'Exercise of Command', 'iscorrect' => 0],
            ['choiceid' => 13, 'questionid' => 4, 'answer' => 'Barangay Captain', 'iscorrect' => 0],
            ['choiceid' => 14, 'questionid' => 4, 'answer' => 'Commander', 'iscorrect' => 1],
            ['choiceid' => 15, 'questionid' => 4, 'answer' => 'General Manager', 'iscorrect' => 0],
            ['choiceid' => 16, 'questionid' => 4, 'answer' => 'Exercise of Command', 'iscorrect' => 0],
            ['choiceid' => 17, 'questionid' => 5, 'answer' => 'PNP Crime Lab', 'iscorrect' => 1],
            ['choiceid' => 18, 'questionid' => 5, 'answer' => 'Firearm and Explosive Office', 'iscorrect' => 0],
            ['choiceid' => 19, 'questionid' => 5, 'answer' => 'PNP SAGSD', 'iscorrect' => 0],
            ['choiceid' => 20, 'questionid' => 5, 'answer' => 'Personnel Manager', 'iscorrect' => 0],
        ];
        DB::table('choicetbl')->insert($choice);
    }
}
