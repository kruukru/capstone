<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = [
            ['username' => 'executive', 'password' => bcrypt('executive'), 'accounttype' => 0],
            ['username' => 'client', 'password' => bcrypt('client'), 'accounttype' => 10],
            ['username' => 'kiksie', 'password' => bcrypt('kiksie'), 'accounttype' => 20],
            ['username' => 'eggie', 'password' => bcrypt('eggie'), 'accounttype' => 20],
            ['username' => 'royie', 'password' => bcrypt('royie'), 'accounttype' => 20],
            ['username' => 'jamie', 'password' => bcrypt('jamie'), 'accounttype' => 20],
            ['username' => 'año', 'password' => bcrypt('año'), 'accounttype' => 20],
            ['username' => 'basilio', 'password' => bcrypt('basilio'), 'accounttype' => 20],
            ['username' => 'bayani', 'password' => bcrypt('bayani'), 'accounttype' => 20],
            ['username' => 'capispisan', 'password' => bcrypt('capispisan'), 'accounttype' => 20],
            ['username' => 'efa', 'password' => bcrypt('efa'), 'accounttype' => 20],
            ['username' => 'lapuz', 'password' => bcrypt('lapuz'), 'accounttype' => 20],
            ['username' => 'publico', 'password' => bcrypt('publico'), 'accounttype' => 20],
            ['username' => 'talban', 'password' => bcrypt('talban'), 'accounttype' => 20],
            ['username' => 'villareal', 'password' => bcrypt('villareal'), 'accounttype' => 20],
            ['username' => 'vivas', 'password' => bcrypt('vivas'), 'accounttype' => 20],
            ['username' => 'admin', 'password' => bcrypt('admin'), 'accounttype' => 1],
            ['username' => 'operation', 'password' => bcrypt('operation'), 'accounttype' => 2],
            ['username' => 'hr', 'password' => bcrypt('hr'), 'accounttype' => 3],
            ['username' => 'client1', 'password' => bcrypt('client1'), 'accounttype' => 10],
        ];
        DB::table('accounttbl')->insert($account);
    }
}
