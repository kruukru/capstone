<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointmentslottbl')->insert([
            'sunday' => 1,
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
            'friday' => 1,
            'saturday' => 1,
            'slot' => 5,
            'noofday' => 10,
        ]);

        $appointmentdate = [
            ['date' => Carbon::today()],
            ['date' => Carbon::today()->addDays(1)],
            ['date' => Carbon::today()->addDays(2)],
            ['date' => Carbon::today()->addDays(3)],
            ['date' => Carbon::today()->addDays(4)],
            ['date' => Carbon::today()->addDays(5)],
            ['date' => Carbon::today()->addDays(6)],
            ['date' => Carbon::today()->addDays(7)],
            ['date' => Carbon::today()->addDays(8)],
            ['date' => Carbon::today()->addDays(9)],
        ];
        DB::table('appointmentdatetbl')->insert($appointmentdate);

        $appointment = [
            ['applicantid' => 1, 'appointmentdateid' => 1],
            ['applicantid' => 2, 'appointmentdateid' => 1],
            ['applicantid' => 3, 'appointmentdateid' => 1],
            ['applicantid' => 4, 'appointmentdateid' => 1],
        ];
        DB::table('appointmenttbl')->insert($appointment);
    }
}
