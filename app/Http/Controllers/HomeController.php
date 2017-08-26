<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Appointment;
use Amcor\Holiday;
use Amcor\Applicant;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;

class HomeController extends Controller
{
    public function index() {
        // $appointmentslot = AppointmentSlot::first();
        // $lastday = Carbon::today()->addDays($appointmentslot->noofday - 1);
        // $appointmentdate = AppointmentDate::where('date', $lastday->format("Y-m-d"))->first();
        // if ($appointmentdate == null) {
        //     $holiday = Holiday::whereMonth('date', $lastday->format("m"))
        //             ->whereDay('date', $lastday->format("d"))->first();
        //     if ($holiday == null) {
        //         $check = false;
        //         if ($lastday->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
        //             $check = true;
        //         } else if ($lastday->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
        //             $check = true;
        //         }

        //         if ($check) {
        //             $appointmentdate = new AppointmentDate;
        //             $appointmentdate->date = $lastday->format("Y-m-d");
        //             $appointmentdate->save();
        //         }
        //     } else if ($holiday->yearly == 1) {
        //         $appointmentdate = new AppointmentDate;
        //         $appointmentdate->holiday()->associate($holiday);
        //         $appointmentdate->date = $lastday->format("Y-m-d");
        //         $appointmentdate->save();
        //     } else if ($holiday->yearly == 0) {
        //         if ($holiday->date->format("Y") == $lastday->format("Y")) {
        //             $appointmentdate = new AppointmentDate;
        //             $appointmentdate->holiday()->associate($holiday);
        //             $appointmentdate->date = $lastday->format("Y-m-d");
        //             $appointmentdate->save();
        //         } else {
        //             $appointmentdate = new AppointmentDate;
        //             $appointmentdate->date = $lastday->format("Y-m-d");
        //             $appointmentdate->save();
        //         }
        //     }
        // }

        // Appointment::whereHas('appointmentdate', function($query) {
        //     $query->where('date', '<', Carbon::today());
        // })->forceDelete();
        // AppointmentDate::where('date', '<', Carbon::today())->forceDelete();

        $appointmentslot = AppointmentSlot::first();
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

        //for resetting the fail status of applicant in 3 month rule
        $applicants = Applicant::where([
            ['updated_at', '<=', Carbon::today()->addMonths(-3)],
            ['status', 125],
        ])->get();
        if (!($applicants->isEmpty())) {
            $applicants->each(function($applicant) {
                $applicant->status = 0;
                $applicant->save();
            });
        }

    	if (Auth::check()) {
    		if (Auth::user()->accounttype == 0) {
	    		return view('admin.home');
	    	} else if (Auth::user()->accounttype == 10) {
	    		return view('client.home');
	    	} else if (Auth::user()->accounttype == 20) {
                return view('applicant.home');
            } else if (Auth::user()->accounttype == 11) {
                return view('manager.home');
            }
    	}

    	return view('index.home');
    }
}
