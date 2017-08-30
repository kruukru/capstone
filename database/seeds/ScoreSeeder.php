<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $score = [
            ['applicantid' => 5, 'testid' => 1, 'score' => 0, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 6, 'testid' => 1, 'score' => 2, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 7, 'testid' => 1, 'score' => 1, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 8, 'testid' => 1, 'score' => 1, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 9, 'testid' => 1, 'score' => 4, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 10, 'testid' => 1, 'score' => 5, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 11, 'testid' => 1, 'score' => 3, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 12, 'testid' => 1, 'score' => 3, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 13, 'testid' => 1, 'score' => 1, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
            ['applicantid' => 14, 'testid' => 1, 'score' => 0, 'item' => 5, 'created_at' => Carbon::today(), 'updated_at' => Carbon::today()],
        ];
        DB::table('scoretbl')->insert($score);
    }
}
