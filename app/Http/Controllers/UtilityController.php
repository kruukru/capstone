<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Holiday;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Appointment;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Response;

class UtilityController extends Controller
{
    public function getAdminAppointment() {
    	$holidays = Holiday::get();
        $appointmentslot = AppointmentSlot::first();

    	return view('admin.utility.appointment', compact('holidays', 'appointmentslot'));
    }

    public function postAdminAppointment(Request $request) {
        $appointmentslot = AppointmentSlot::first();

        $appointmentslot->sunday = $request->inputSunday == "true" ? 1: 0;
        $appointmentslot->monday = $request->inputMonday == "true" ? 1: 0;
        $appointmentslot->tuesday = $request->inputTuesday == "true" ? 1: 0;
        $appointmentslot->wednesday = $request->inputWednesday == "true" ? 1: 0;
        $appointmentslot->thursday = $request->inputThursday == "true" ? 1: 0;
        $appointmentslot->friday = $request->inputFriday == "true" ? 1: 0;
        $appointmentslot->saturday = $request->inputSaturday == "true" ? 1: 0;
        $appointmentslot->slot = $request->inputSlot;
        $appointmentslot->noofday = $request->inputDay;
        $appointmentslot->save();

        $begin = new DateTime(Carbon::today());
        $end = new DateTime(Carbon::today()->addDays($appointmentslot->noofday));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $appointmentdate = AppointmentDate::where('date', $dt->format("Y-m-d"))->first();
            if ($appointmentdate == null) {
                $holiday = Holiday::whereMonth('date', $dt->format("m"))
                    ->whereDay('date', $dt->format("d"))->first();
                if ($holiday == null) {
                    $check = false;
                    if ($dt->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
                        $check = true;
                    }

                    if ($check) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    }
                } else if ($holiday->yearly == 1) {
                    $appointmentdate = new AppointmentDate;
                    $appointmentdate->holiday()->associate($holiday);
                    $appointmentdate->date = $dt->format("Y-m-d");
                    $appointmentdate->save();
                } else if ($holiday->yearly == 0) {
                    if ($holiday->date->format("Y") == $dt->format("Y")) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    } else {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    }
                }
            } else {
                $holiday = Holiday::whereMonth('date', $dt->format("m"))
                    ->whereDay('date', $dt->format("d"))->first();
                if ($holiday == null) {
                    $check = true;
                    if ($dt->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
                        $check = false;
                    }

                    if ($check) {
                        $appointmentdate->appointment()->delete();
                        $appointmentdate->delete();
                    }
                } else if ($holiday->yearly == 1) {
                    if ($appointmentdate == null) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    } else {
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->save();
                    }
                } else if ($holiday->yearly == 0) {
                    if ($holiday->date->format("Y") == $dt->format("Y")) {
                        if ($appointmentdate == null) {
                            $appointmentdate = new AppointmentDate;
                            $appointmentdate->holiday()->associate($holiday);
                            $appointmentdate->date = $dt->format("Y-m-d");
                            $appointmentdate->save();
                        } else {
                            $appointmentdate->holiday()->associate($holiday);
                            $appointmentdate->save();
                        }
                    }
                }
            }
        }

        Appointment::whereHas('appointmentdate', function($query) {
            $query->where('date', '<', Carbon::today());
        })->forceDelete();
        Appointment::whereHas('appointmentdate', function($query) use ($appointmentslot) {
            $query->where('date', '>=', Carbon::today()->addDays($appointmentslot->noofday));
        })->forceDelete();
        AppointmentDate::where('date', '<', Carbon::today())->forceDelete();
        AppointmentDate::where('date', '>=', Carbon::today()->addDays($appointmentslot->noofday))->forceDelete();

        return Response::json($appointmentslot);
    }

    public function postAdminHolidayNew(Request $request) {
    	$holiday = Holiday::where('name', $request->inputHoliday)
            ->first();
        if ($holiday !== null) {
        	return Response::json("SAME NAME", 500);
        }
        $inputHolidayDate = Carbon::parse($request->inputHolidayDate);
        $holiday = Holiday::whereMonth('date', $inputHolidayDate->month)
        	->whereDay('date', $inputHolidayDate->day)
        	->first();
        if ($holiday !== null) {
        	return Response::json("SAME DATE", 500);
        }

        $request->inputHolidayYearly = $request->inputHolidayYearly === "true"? 1: 0;

        $holiday = new Holiday;
        $holiday->name = $request->inputHoliday;
        $holiday->date = $request->inputHolidayDate;
        $holiday->yearly = $request->inputHolidayYearly;
        $holiday->save();

        return Response::json($holiday);
    }

    public function postAdminHolidayUpdate(Request $request) {
        $holiday = Holiday::where([
                ['name', $request->inputHoliday],
                ['holidayid', '!=', $request->inputHolidayID],
            ])->first();
        if ($holiday !== null) {
            return Response::json("SAME NAME", 500);
        }
        $inputHolidayDate = Carbon::parse($request->inputHolidayDate);
        $holiday = Holiday::where('holidayid', '!=', $request->inputHolidayID)
            ->whereMonth('date', $inputHolidayDate->month)
            ->whereDay('date', $inputHolidayDate->day)
            ->first();
        if ($holiday !== null) {
            return Response::json("SAME DATE", 500);
        }

        $request->inputHolidayYearly = $request->inputHolidayYearly === "true"? 1: 0;

        $holiday = Holiday::find($request->inputHolidayID);
        $holiday->name = $request->inputHoliday;
        $holiday->date = $request->inputHolidayDate;
        $holiday->yearly = $request->inputHolidayYearly;
        $holiday->save();

        return Response::json($holiday);
    }

    public function postAdminHolidayRemove(Request $request) {
        $holiday = Holiday::find($request->inputHolidayID);
        $holiday->delete();

        return Response::json($holiday);
    }
}
