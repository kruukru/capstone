<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = [
            ['questionid' => 1, 'type' => 0, 'question' => 'The fundamental law of the land'],
            ['questionid' => 2, 'type' => 0, 'question' => 'For the safety of everybody, a gun shall be always treated as'],
            ['questionid' => 3, 'type' => 0, 'question' => 'Type of leadership takes into consideration the human element with its complexity and with all security agencies in the Philippines'],
            ['questionid' => 4, 'type' => 0, 'question' => 'A title of an officer of a detachment or larger unit'],
            ['questionid' => 5, 'type' => 0, 'question' => 'An office under the command of PNP tasked to supervised and control the operation of all security agencies in the Philippines'],
        ];
        DB::table('questiontbl')->insert($question);
    }
}
