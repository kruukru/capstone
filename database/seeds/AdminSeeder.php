<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            ['accountid' => 1,
            'picture' => 'default.png',
            'lastname' => 'Last Name',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'position' => 'Executive'],
            ['accountid' => 17,
            'picture' => 'default.png',
            'lastname' => 'Last Name',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'position' => 'Admin'],
            ['accountid' => 18,
            'picture' => 'default.png',
            'lastname' => 'Last Name',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'position' => 'Operation'],
            ['accountid' => 19,
            'picture' => 'default.png',
            'lastname' => 'Last Name',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'position' => 'HR']
        ];
        DB::table('admintbl')->insert($admin);
    }
}
