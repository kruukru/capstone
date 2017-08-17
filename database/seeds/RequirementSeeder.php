<?php

use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requirement = [
            ['name' => 'NBI Clearance'],
            ['name' => 'Medical Certificate'],
            ['name' => 'Barangay Clearance'],
            ['name' => 'Good Moral'],
        ];
        DB::table('requirementtbl')->insert($requirement);

        $applicantrequirement = [
            ['applicantid' => 1, 'requirementid' => 1, 'issubmitted' => 0],
            ['applicantid' => 1, 'requirementid' => 2, 'issubmitted' => 0],
            ['applicantid' => 1, 'requirementid' => 3, 'issubmitted' => 0],
            ['applicantid' => 1, 'requirementid' => 4, 'issubmitted' => 0],
            ['applicantid' => 2, 'requirementid' => 1, 'issubmitted' => 0],
            ['applicantid' => 2, 'requirementid' => 2, 'issubmitted' => 0],
            ['applicantid' => 2, 'requirementid' => 3, 'issubmitted' => 0],
            ['applicantid' => 2, 'requirementid' => 4, 'issubmitted' => 0],
            ['applicantid' => 3, 'requirementid' => 1, 'issubmitted' => 0],
            ['applicantid' => 3, 'requirementid' => 2, 'issubmitted' => 0],
            ['applicantid' => 3, 'requirementid' => 3, 'issubmitted' => 0],
            ['applicantid' => 3, 'requirementid' => 4, 'issubmitted' => 0],
            ['applicantid' => 4, 'requirementid' => 1, 'issubmitted' => 0],
            ['applicantid' => 4, 'requirementid' => 2, 'issubmitted' => 0],
            ['applicantid' => 4, 'requirementid' => 3, 'issubmitted' => 0],
            ['applicantid' => 4, 'requirementid' => 4, 'issubmitted' => 0],
        ];
        DB::table('applicantrequirementtbl')->insert($applicantrequirement);
    }
}
