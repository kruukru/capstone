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
            ['itemtypeid' => 1, 'name' => 'Revolver', 'qty' => 10, 'qtyavailable' => 10],
            ['itemtypeid' => 1, 'name' => 'Austrian Glock', 'qty' => 10, 'qtyavailable' => 10],
            ['itemtypeid' => 1, 'name' => 'Ruger P', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 1, 'name' => 'Colt 1911', 'qty' => 0, 'qtyavailable' => 0],
            ['itemtypeid' => 2, 'name' => 'Radio', 'qty' => 50, 'qtyavailable' => 50],
            ['itemtypeid' => 2, 'name' => 'Raincoat', 'qty' => 27, 'qtyavailable' => 27],
            ['itemtypeid' => 2, 'name' => 'Rainboot', 'qty' => 27, 'qtyavailable' => 27],
            ['itemtypeid' => 2, 'name' => 'Metal Detector', 'qty' => 35, 'qtyavailable' => 35],
            ['itemtypeid' => 2, 'name' => 'Traffic Vest', 'qty' => 75, 'qtyavailable' => 75],
            ['itemtypeid' => 2, 'name' => 'Umbrella', 'qty' => 55, 'qtyavailable' => 55],
            ['itemtypeid' => 2, 'name' => 'Flashlight', 'qty' => 38, 'qtyavailable' => 38],
            ['itemtypeid' => 2, 'name' => 'Traffic Baton', 'qty' => 47, 'qtyavailable' => 47],
            ['itemtypeid' => 2, 'name' => 'Medicine Box/Kit', 'qty' => 48, 'qtyavailable' => 48],
            ['itemtypeid' => 3, 'name' => 'USB', 'qty' => 10, 'qtyavailable' => 10],
            ['itemtypeid' => 3, 'name' => 'Digital Camera', 'qty' => 2, 'qtyavailable' => 2],
            ['itemtypeid' => 4, 'name' => 'Scissor', 'qty' => 74, 'qtyavailable' => 74],
            ['itemtypeid' => 4, 'name' => 'Stapler', 'qty' => 32, 'qtyavailable' => 32],
            ['itemtypeid' => 4, 'name' => 'Ruler', 'qty' => 36, 'qtyavailable' => 36],
            ['itemtypeid' => 4, 'name' => 'Scotch Tape', 'qty' => 34, 'qtyavailable' => 34],
            ['itemtypeid' => 4, 'name' => 'Cutter', 'qty' => 35, 'qtyavailable' => 35],
        ];
        DB::table('itemtbl')->insert($item);
    }
}
