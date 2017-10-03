<?php

use Illuminate\Database\Seeder;

class CommendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commend = [
            ['name' => 'Perfect Attendance'],
            ['name' => 'Always Ready'],
            ['name' => 'Being Helpful']
        ];
        DB::table('commendtbl')->insert($commend);
    }
}
