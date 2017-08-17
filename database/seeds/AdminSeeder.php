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
            ['accountid' => 1, 'lastname' => 'Geronimo', 'firstname' => 'Jermaine', 'middlename' => 'Manalo', 'position' => 'Admin', 'department' => 'Admin'],
        ];
        DB::table('admintbl')->insert($admin);
    }
}
