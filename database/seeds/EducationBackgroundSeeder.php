<?php

use Illuminate\Database\Seeder;

class EducationBackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educatinbackground = [
            ['applicantid' => 1, 'graduatetype' => 'Elementary', 'degree' => null, 'dategraduated' => '2010-03-10', 'schoolgraduated' => 'Peñafrancia Elementary School'],
            ['applicantid' => 1, 'graduatetype' => 'High School', 'degree' => null, 'dategraduated' => '2014-03-21', 'schoolgraduated' => 'Mambugan National High School'],
            ['applicantid' => 1, 'graduatetype' => 'College', 'degree' => 'Bachelor of Science in Information Technology', 'dategraduated' => '2018-03-25', 'schoolgraduated' => 'Polytechnic University of the Philippines'],
            ['applicantid' => 1, 'graduatetype' => 'Vocational', 'degree' => 'Welding', 'dategraduated' => '2017-03-25', 'schoolgraduated' => 'TESDA'],
            ['applicantid' => 2, 'graduatetype' => 'Elementary', 'degree' => null, 'dategraduated' => '2010-03-15', 'schoolgraduated' => 'Paaralang Mababa Elementary School'],
            ['applicantid' => 2, 'graduatetype' => 'High School', 'degree' => null, 'dategraduated' => '2014-03-15', 'schoolgraduated' => 'Paaralang Mababa High School'],
            ['applicantid' => 3, 'graduatetype' => 'Elementary', 'degree' => null, 'dategraduated' => '2010-03-18', 'schoolgraduated' => 'Paaralang Mababa Elementary School'],
            ['applicantid' => 4, 'graduatetype' => 'Elementary', 'degree' => 'Grade 6', 'dategraduated' => '2010-03-23', 'schoolgraduated' => 'Holy Child Montessori School'],
            ['applicantid' => 4, 'graduatetype' => 'High School', 'degree' => '4th Year', 'dategraduated' => '2014-03-21', 'schoolgraduated' => 'Mandaluyong High School'],
            ['applicantid' => 4, 'graduatetype' => 'College', 'degree' => 'Bachelor of Science in Information Technology', 'dategraduated' => '2018-03-25', 'schoolgraduated' => 'Polytechnic University of the Philippines'],
        ];
        DB::table('educationbackgroundtbl')->insert($educatinbackground);
    }
}
