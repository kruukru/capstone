<?php

use Illuminate\Database\Seeder;

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
            'contactno' => 'Tel No. 531-2558, 531-2517 & 531-2593',
            'logo' => 'amcor.png'
        ]);
    }
}
