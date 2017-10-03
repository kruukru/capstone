<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contracttbl')->insert([
        	'clientid' => 1,
        	'adminid' => 1,
        	'startdate' => Carbon::today(),
        	'expiration' => Carbon::today()->addDays(75),
        	'placesigned' => 'Amcor',
        	'price' => '4,500.00',
        	'status' => 0,
        ]);

        DB::table('contracttbl')->insert([
        	'clientid' => 1,
        	'adminid' => 1,
        	'startdate' => Carbon::today(),
        	'expiration' => Carbon::today()->addDays(85),
        	'placesigned' => 'Amcor',
        	'price' => '2,500.00',
        	'status' => 0,
        ]);
    }
}
