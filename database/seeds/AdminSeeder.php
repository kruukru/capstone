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
            ['accountid' => 1, 'picture' => 'default.png', 'lastname' => 'Geronimo', 'firstname' => 'Rodrigo', 'middlename' => 'Manalo', 'position' => 'Executive'],
            ['accountid' => 17, 'picture' => 'default.png', 'lastname' => 'Geronimo', 'firstname' => 'Constancia', 'middlename' => 'Manalo', 'position' => 'Admin'],
            ['accountid' => 18, 'picture' => 'default.png', 'lastname' => 'Geronimo', 'firstname' => 'Jennifer', 'middlename' => 'Manalo', 'position' => 'Operation'],
            ['accountid' => 19, 'picture' => 'default.png', 'lastname' => 'Geronimo', 'firstname' => 'Jerrico', 'middlename' => 'Manalo', 'position' => 'HR']
        ];
        DB::table('admintbl')->insert($admin);
    }
}
