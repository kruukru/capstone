<?php

use Illuminate\Database\Seeder;

class AreaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areatype = [
            ['name' => 'Manila', 'amountperhour' => '4,500.00'],
            ['name' => 'Cavite', 'amountperhour' => '600.00'],
            ['name' => 'Pasay', 'amountperhour' => '5,550.00'],
        ];
        DB::table('areatypetbl')->insert($areatype);
    }
}
