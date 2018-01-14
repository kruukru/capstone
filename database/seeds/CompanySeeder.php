<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companytbl')->insert([
            'name' => 'Security Guard Agency',
            'shortname' => 'SG',
            'address' => 'Address',
            'license' => 'XXX-999999-999',
            'expiration' => Carbon::today()->addYears(3),
            'contactno' => 'Contact',
            'email' => 'email@email.com',
            'logo' => 'logo.png'
        ]);
    }
}
