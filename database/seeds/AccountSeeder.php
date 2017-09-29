<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = [
            ['username' => 'executive', 'password' => bcrypt('executive'), 'accounttype' => 0],
            ['username' => 'client', 'password' => bcrypt('client'), 'accounttype' => 10],
            ['username' => 'kiksie', 'password' => bcrypt('kiksie'), 'accounttype' => 20],
            ['username' => 'eggie', 'password' => bcrypt('eggie'), 'accounttype' => 20],
            ['username' => 'royie', 'password' => bcrypt('royie'), 'accounttype' => 20],
            ['username' => 'jamie', 'password' => bcrypt('jamie'), 'accounttype' => 20],
            ['username' => 'applicant1', 'password' => bcrypt('applicant1'), 'accounttype' => 20],
            ['username' => 'applicant2', 'password' => bcrypt('applicant2'), 'accounttype' => 20],
            ['username' => 'applicant3', 'password' => bcrypt('applicant3'), 'accounttype' => 20],
            ['username' => 'applicant4', 'password' => bcrypt('applicant4'), 'accounttype' => 20],
            ['username' => 'applicant5', 'password' => bcrypt('applicant5'), 'accounttype' => 20],
            ['username' => 'applicant6', 'password' => bcrypt('applicant6'), 'accounttype' => 20],
            ['username' => 'applicant7', 'password' => bcrypt('applicant7'), 'accounttype' => 20],
            ['username' => 'applicant8', 'password' => bcrypt('applicant8'), 'accounttype' => 20],
            ['username' => 'applicant9', 'password' => bcrypt('applicant9'), 'accounttype' => 20],
            ['username' => 'applicant10', 'password' => bcrypt('applicant10'), 'accounttype' => 20],
            ['username' => 'admin', 'password' => bcrypt('admin'), 'accounttype' => 1],
            ['username' => 'operation', 'password' => bcrypt('operation'), 'accounttype' => 2],
            ['username' => 'hr', 'password' => bcrypt('hr'), 'accounttype' => 3]
        ];
        DB::table('accounttbl')->insert($account);
    }
}
