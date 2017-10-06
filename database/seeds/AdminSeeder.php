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
            ['accountid' => 1, 'picture' => 'default.png', 'lastname' => 'executive', 'firstname' => 'executive', 'middlename' => 'executive', 'position' => 'Executive'],
            ['accountid' => 17, 'picture' => 'default.png', 'lastname' => 'admin', 'firstname' => 'admin', 'middlename' => 'admin', 'position' => 'Admin'],
            ['accountid' => 18, 'picture' => 'default.png', 'lastname' => 'operation', 'firstname' => 'operation', 'middlename' => 'operation', 'position' => 'Operation'],
            ['accountid' => 19, 'picture' => 'default.png', 'lastname' => 'hr', 'firstname' => 'hr', 'middlename' => 'hr', 'position' => 'HR']
        ];
        DB::table('admintbl')->insert($admin);
    }
}
