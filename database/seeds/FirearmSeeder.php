<?php

use Illuminate\Database\Seeder;

class FirearmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$firearm = [
            ['itemid' => 1, 'license' => 'A11AA1111110', 'expiration' => "2020-01-25"],
            ['itemid' => 1, 'license' => 'A11AA1111111', 'expiration' => "2020-03-27"],
            ['itemid' => 1, 'license' => 'A11AA1111112', 'expiration' => "2020-02-15"],
            ['itemid' => 1, 'license' => 'A11AA1111113', 'expiration' => "2020-09-19"],
            ['itemid' => 1, 'license' => 'A11AA1111114', 'expiration' => "2020-12-10"],
            ['itemid' => 1, 'license' => 'A11AA1111115', 'expiration' => "2020-11-09"],
            ['itemid' => 1, 'license' => 'A11AA1111116', 'expiration' => "2020-05-15"],
            ['itemid' => 1, 'license' => 'A11AA1111117', 'expiration' => "2020-06-24"],
            ['itemid' => 1, 'license' => 'A11AA1111118', 'expiration' => "2020-01-10"],
            ['itemid' => 1, 'license' => 'A11AA1111119', 'expiration' => "2020-01-16"],
            ['itemid' => 2, 'license' => 'B11AA1111110', 'expiration' => "2020-01-25"],
            ['itemid' => 2, 'license' => 'B11AA1111111', 'expiration' => "2020-03-27"],
            ['itemid' => 2, 'license' => 'B11AA1111112', 'expiration' => "2020-02-15"],
            ['itemid' => 2, 'license' => 'B11AA1111113', 'expiration' => "2020-09-19"],
            ['itemid' => 2, 'license' => 'B11AA1111114', 'expiration' => "2020-12-10"],
            ['itemid' => 2, 'license' => 'B11AA1111115', 'expiration' => "2020-11-09"],
            ['itemid' => 2, 'license' => 'B11AA1111116', 'expiration' => "2020-05-15"],
            ['itemid' => 2, 'license' => 'B11AA1111117', 'expiration' => "2020-06-24"],
            ['itemid' => 2, 'license' => 'B11AA1111118', 'expiration' => "2020-01-10"],
            ['itemid' => 2, 'license' => 'B11AA1111119', 'expiration' => "2020-01-16"],
        ];
        DB::table('firearmtbl')->insert($firearm);
    }
}
