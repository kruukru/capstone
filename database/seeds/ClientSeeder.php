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
            'picture' => 'default.png',
            'lastname' => 'Geronimo',
            'firstname' => 'Jervy',
            'middlename' => 'Manalo',
            'position' => 'Admin',
            'contactpersonno' => '(02) 254 9192',
        	'company' => '5J Store',
        	'address' => '1326 Masinop St. Tondo Manila',
        	'companycontactno' => '+63 950 4869 682',
        	'email' => '5jstore@gmail.com',
            'status' => 1,
        ]);

        DB::table('clienttbl')->insert([
            'accountid' => 20,
            'picture' => 'default.png',
            'lastname' => 'Geronimo',
            'firstname' => 'Jerwin',
            'middlename' => 'Manalo',
            'position' => 'Admin',
            'contactpersonno' => '+63 950 4869 682',
            'company' => 'Polytechnic University of the Philippines',
            'address' => 'Sta. Mesa',
            'companycontactno' => '+63 950 4869 682',
            'email' => 'pup@gmail.com',
            'status' => 0,
        ]);
    }
}
