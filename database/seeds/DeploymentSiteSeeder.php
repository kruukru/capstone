<?php

use Illuminate\Database\Seeder;

class DeploymentSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deploymentsitetbl')->insert([
        	'contractid' => 1,
        	'sitename' => '5J Store Sta. Mesa',
        	'location' => 'Sta. Mesa',
        	'city' => 'Manila',
        	'province' => 'Metro Manila',
        	'latitude' => 14.5976323,
        	'longitude' => 121.01760919999992,
        	'status' => 0,
        ]);

        DB::table('deploymentsitetbl')->insert([
        	'contractid' => 2,
        	'sitename' => '5J Store San Juan',
        	'location' => 'San Juan',
        	'city' => 'San Juan',
        	'province' => 'Metro Manila',
        	'latitude' => 14.5974549,
        	'longitude' => 121.03672030000007,
        	'status' => 0,
        ]);
    }
}
