<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(ChoiceSeeder::class);
        $this->call(TestSeeder::class);
        $this->call(ApplicantSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(RequirementSeeder::class);
        $this->call(AssessmentTopicSeeder::class);
        $this->call(EducationBackgroundSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ItemTypeSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(FirearmSeeder::class);
        $this->call(ScoreSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CommendSeeder::class);
        $this->call(ViolationSeeder::class);
        $this->call(ContractSeeder::class);
        $this->call(DeploymentSiteSeeder::class);
        $this->call(HolidaySeeder::class);
    }
}
