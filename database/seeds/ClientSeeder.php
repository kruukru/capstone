<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clienttbl')->insert([
        	'accountid' => 2,
        	'name' => '5J Store',
        	'address' => '1326 Masinop St. Tondo Manila',
        	'contactno' => '+63 950 4869 682',
        	'contactperson' => 'Rodrigo Geronimo',
        	'contactpersonno' => '(02) 254 9192',
        	'email' => '5jstore@gmail.com',
        ]);
    }
}
