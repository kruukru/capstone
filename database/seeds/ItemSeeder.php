<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
            ['itemtypeid' => 1, 'name' => 'Revolver', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 1, 'name' => 'Austrian Glock', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 1, 'name' => 'Ruger P', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 1, 'name' => 'Colt 1911', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 2, 'name' => 'Radio', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 3, 'name' => 'Ballpen', 'qty' => 0, 'qtyavailable' => 0],
        ];
        DB::table('itemtbl')->insert($item);
    }
}
