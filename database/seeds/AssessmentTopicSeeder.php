<?php

use Illuminate\Database\Seeder;

class AssessmentTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assessmenttopic = [
            ['name' => 'Family'],
            ['name' => 'Financial'],
            ['name' => 'Health'],
        ];
        DB::table('assessmenttopictbl')->insert($assessmenttopic);
    }
}
