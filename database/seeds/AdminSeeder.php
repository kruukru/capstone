<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            ['accountid' => 1,
            'picture' => '1507877500ULkoPOi.jpg',
            'lastname' => 'Geronimo',
            'firstname' => 'Jermaine',
            'middlename' => 'Manalo',
            'position' => 'Executive'],
            ['accountid' => 17,
            'picture' => '150787773518815229_10208571080063801_6939372764992996976_o.jpg',
            'lastname' => 'Gallardo',
            'firstname' => 'Christian',
            'middlename' => 'Ansing',
            'position' => 'Admin'],
            ['accountid' => 18,
            'picture' => '150787774921950847_1825081084186799_7960118726896741689_o.jpg',
            'lastname' => 'Egos',
            'firstname' => 'John Christopher',
            'middlename' => 'Gregorio',
            'position' => 'Operation'],
            ['accountid' => 19,
            'picture' => '150787775516831910_1794274003932075_6952753733309801712_n.jpg',
            'lastname' => 'Tolentino',
            'firstname' => 'Roy Emmanuel',
            'middlename' => 'Tena',
            'position' => 'HR']
        ];
        DB::table('admintbl')->insert($admin);
    }
}
