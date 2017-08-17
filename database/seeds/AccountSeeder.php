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
            ['username' => 'admin', 'password' => bcrypt('admin'), 'accounttype' => 0],
            ['username' => 'client', 'password' => bcrypt('client'), 'accounttype' => 10],
            ['username' => 'kiksie', 'password' => bcrypt('kiksie'), 'accounttype' => 20],
            ['username' => 'eggie', 'password' => bcrypt('eggie'), 'accounttype' => 20],
            ['username' => 'royie', 'password' => bcrypt('royie'), 'accounttype' => 20],
            ['username' => 'jamie', 'password' => bcrypt('jamie'), 'accounttype' => 20],
        ];
        DB::table('accounttbl')->insert($account);
    }
}
