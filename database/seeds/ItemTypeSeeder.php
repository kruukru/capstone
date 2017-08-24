<?php

use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemtype = [
            ['name' => 'Firearm'],
            ['name' => 'Equipment'],
            ['name' => 'Accessory'],
            ['name' => 'Supply'],
        ];
        DB::table('itemtypetbl')->insert($itemtype);
    }
}
