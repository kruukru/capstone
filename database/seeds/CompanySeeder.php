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
            'name' => 'AMCOR Security & Investigation Agency, Inc.',
            'shortname' => 'AMCOR',
            'address' => '353 Doña Dolores Building San Rafael St., Brgy. Plainview Mandaluyong City',
            'license' => 'PSA-130548-2017',
            'expiration' => Carbon::today()->addYears(3),
            'contactno' => 'Tel No. 531-2558, 531-2517 & 531-2593',
            'email' => 'amcor_group@yahoo.com',
            'logo' => 'amcor.png'
        ]);
    }
}
