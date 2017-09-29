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
            ['accountid' => 1, 'lastname' => 'executive', 'firstname' => 'executive', 'middlename' => 'executive', 'position' => 'Executive', 'department' => 'Executive'],
            ['accountid' => 17, 'lastname' => 'admin', 'firstname' => 'admin', 'middlename' => 'admin', 'position' => 'Admin', 'department' => 'Admin'],
            ['accountid' => 18, 'lastname' => 'operation', 'firstname' => 'operation', 'middlename' => 'operation', 'position' => 'Operation', 'department' => 'Operation'],
            ['accountid' => 19, 'lastname' => 'hr', 'firstname' => 'hr', 'middlename' => 'hr', 'position' => 'HR', 'department' => 'HR']
        ];
        DB::table('admintbl')->insert($admin);
    }
}
