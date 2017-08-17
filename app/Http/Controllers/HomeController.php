<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Holiday;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    public function index() {
        $appointmentslot = AppointmentSlot::first();
        $lastday = Carbon::today()->addDays($appointmentslot->noofday - 1);
        $appointmentdate = AppointmentDate::where('date', $lastday->format("Y-m-d"))->first();
        if ($appointmentdate == null) {
            $holiday = Holiday::whereMonth('date', $lastday->format("m"))
                    ->whereDay('date', $lastday->format("d"))->first();
            if ($holiday == null) {
                $check = false;
                if ($lastday->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
                    $check = true;
                } else if ($lastday->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
                    $check = true;
                }

                if ($check) {
                    $appointmentdate = new AppointmentDate;
                    $appointmentdate->date = $lastday->format("Y-m-d");
                    $appointmentdate->save();
                }
            } else if ($holiday->yearly == 1) {
                $appointmentdate = new AppointmentDate;
                $appointmentdate->holiday()->associate($holiday);
                $appointmentdate->date = $lastday->format("Y-m-d");
                $appointmentdate->save();
            } else if ($holiday->yearly == 0) {
                if ($holiday->date->format("Y") == $lastday->format("Y")) {
                    $appointmentdate = new AppointmentDate;
                    $appointmentdate->holiday()->associate($holiday);
                    $appointmentdate->date = $lastday->format("Y-m-d");
                    $appointmentdate->save();
                } else {
                    $appointmentdate = new AppointmentDate;
                    $appointmentdate->date = $lastday->format("Y-m-d");
                    $appointmentdate->save();
                }
            }
        }

        AppointmentDate::where('date', '<', Carbon::today())->delete();

    	if (Auth::check()) {
    		if (Auth::user()->accounttype == 0) {
	    		return view('admin.home');
	    	} else if (Auth::user()->accounttype == 10) {
	    		return view('client.home');
	    	} else if (Auth::user()->accounttype == 20) {
                return view('applicant.home');
            }
    	}

    	return view('index.home');
    }
}
