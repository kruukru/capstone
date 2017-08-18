<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicanttbl')->insert([
        	'accountid' => 3,
        	'lastname' => 'Gallardo',
            'firstname' => 'Christian',
            'middlename' => 'Ansing',
            'suffix' => null,
            'cityaddress' => 'Dalanghita St.',
            'cityaddresscity' => 'Antipolo City',
            'cityaddressprovince' => 'Rizal',
            'provincialaddress' => null,
            'provincialaddresscity' => null,
            'provincialaddressprovince' => null,
            'latitude' => 14.5979692,
            'longitude' => 121.1351785,
            'gender' => 'Male',
            'picture' => 'default.png',
            'dateofbirth' => '1998-01-23',
            'placeofbirth' => 'Quezon City',
            'age' => 19,
            'civilstatus' => 'Single',
            'religion' => 'Born-Again Christian',
            'bloodtype' => 'A',
            'appcontactno' => '+63 975 1439 665',
            'workexp' => 0,
            'height' => 172,
            'weight' => 68,
            'license' => 'aaa11111111111',
            'licenseexpiration' => '2020-10-10',
            'sss' => '11-1111111-1',
            'philhealth' => '11-111111111-1',
            'pagibig' => '1111-1111-1111',
            'tin' => '111-111-111-111',
            'hobby' => null,
            'skill' => null,
            'spousename' => null,
            'spousedateofbirth' => null,
            'spouseoccupation' => null,
            'contactperson' => 'Honorato A. Gallardo Jr.',
            'contactno' => '+63 935 2752 342',
            'lastdeployed' => null,
        	'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('applicanttbl')->insert([
            'accountid' => 4,
            'lastname' => 'Egos',
            'firstname' => 'John Christopher',
            'middlename' => 'Gregorio',
            'suffix' => null,
            'cityaddress' => '116 Bagong Kalsada St.',
            'cityaddresscity' => 'Navotas',
            'cityaddressprovince' => 'Metro Manila',
            'provincialaddress' => null,
            'provincialaddresscity' => null,
            'provincialaddressprovince' => null,
            'latitude' => 14.6714345,
            'longitude' => 120.9334183,
            'gender' => 'Male',
            'picture' => 'default.png',
            'dateofbirth' => '1999-07-16',
            'placeofbirth' => 'Manila',
            'age' => 18,
            'civilstatus' => 'Single',
            'religion' => 'Catholic',
            'bloodtype' => 'A',
            'appcontactno' => '+63 919 2133 161',
            'workexp' => 0,
            'height' => 167,
            'weight' => 128,
            'license' => 'bbb22222222222',
            'licenseexpiration' => '2020-10-10',
            'sss' => '22-2222222-2',
            'philhealth' => '22-222222222-2',
            'pagibig' => '2222-2222-2222',
            'tin' => '222-222-222-222',
            'hobby' => null,
            'skill' => null,
            'spousename' => null,
            'spousedateofbirth' => null,
            'spouseoccupation' => null,
            'contactperson' => 'Teodulo Egos',
            'contactno' => '+63 929 4001 021',
            'lastdeployed' => null,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()->addDays(-13),
        ]);

        DB::table('applicanttbl')->insert([
            'accountid' => 5,
            'lastname' => 'Tolentino',
            'firstname' => 'Roy Emmanuel',
            'middlename' => 'Tena',
            'suffix' => null,
            'cityaddress' => '13D Sta. Catalina St.',
            'cityaddresscity' => 'Quezon City',
            'cityaddressprovince' => 'Metro Manila',
            'provincialaddress' => null,
            'provincialaddresscity' => null,
            'provincialaddressprovince' => null,
            'latitude' => 14.6864228,
            'longitude' => 121.0840108,
            'gender' => 'Male',
            'picture' => 'default.png',
            'dateofbirth' => '1999-12-31',
            'placeofbirth' => 'Quezon City',
            'age' => 19,
            'civilstatus' => 'Single',
            'religion' => 'Born-Again Christian',
            'bloodtype' => 'O',
            'appcontactno' => '+63 926 9315 798',
            'workexp' => 0,
            'height' => 160,
            'weight' => 48,
            'license' => 'ccc33333333333',
            'licenseexpiration' => '2020-10-10',
            'sss' => '33-1111111-3',
            'philhealth' => '33-333333333-3',
            'pagibig' => '3333-3333-3333',
            'tin' => '333-333-333-333',
            'hobby' => null,
            'skill' => null,
            'spousename' => null,
            'spousedateofbirth' => null,
            'spouseoccupation' => null,
            'contactperson' => 'Marietta Tolentino',
            'contactno' => '+63 946 4774 597',
            'lastdeployed' => null,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()->addDays(-23),
        ]);

        DB::table('applicanttbl')->insert([
            'accountid' => 6,
            'lastname' => 'Astudillo',
            'firstname' => 'Jamee Camille',
            'middlename' => 'Hetigan',
            'suffix' => null,
            'cityaddress' => '3 Sto. Rosario St.',
            'cityaddresscity' => 'Mandaluyong City',
            'cityaddressprovince' => 'Metro Manila',
            'provincialaddress' => null,
            'provincialaddresscity' => null,
            'provincialaddressprovince' => null,
            'latitude' => 14.5764227,
            'longitude' => 121.0333276,
            'gender' => 'Female',
            'picture' => 'default.png',
            'dateofbirth' => '1997-07-05',
            'placeofbirth' => 'Manila',
            'age' => 20,
            'civilstatus' => 'Single',
            'religion' => 'Catholic',
            'bloodtype' => 'A',
            'appcontactno' => '+63 936 6975 144',
            'workexp' => 0,
            'height' => 152,
            'weight' => 49,
            'license' => 'ddd44444444444',
            'licenseexpiration' => '2020-10-10',
            'sss' => '44-4444444-4',
            'philhealth' => '44-444444444-4',
            'pagibig' => '4444-4444-4444',
            'tin' => '444-444-444-444',
            'hobby' => null,
            'skill' => null,
            'spousename' => null,
            'spousedateofbirth' => null,
            'spouseoccupation' => null,
            'contactperson' => 'Christa Janella Astudillo',
            'contactno' => '+63 926 3709 030',
            'lastdeployed' => null,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()->addDays(-48),
        ]);
    }
}
