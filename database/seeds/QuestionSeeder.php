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
            ['type' => 0, 'question' => 'The fundamental law of the land'],
            ['type' => 0, 'question' => 'For the safety of everybody, a gun shall be always treated as'],
            ['type' => 0, 'question' => 'Type of leadership takes into consideration the human element with its complexity and with all security agencies in the Philippines'],
            ['type' => 0, 'question' => 'A title of an officer of a detachment or larger unit'],
            ['type' => 0, 'question' => 'An office under the command of PNP tasked to supervised and control the operation of all security agencies in the Philippines'],
            ['type' => 3, 'question' => 'I feel that my father seldom'],
            ['type' => 3, 'question' => 'When the odds are against me'],
            ['type' => 3, 'question' => 'I always wanted to'],
            ['type' => 3, 'question' => 'If I were in charge'],
            ['type' => 3, 'question' => 'To me the future looks'],
        ];
        DB::table('questiontbl')->insert($question);
    }
}
