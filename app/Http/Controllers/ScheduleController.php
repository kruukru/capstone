<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\Schedule;
use Amcor\DeploymentSite;
use Amcor\Attendance;
use Amcor\LeaveRequest;
use Amcor\Requestt;
use Carbon\Carbon;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;

class ScheduleController extends Controller
{
    //client client client client client client client client client client client client client client client client client client client client 
    public function getClientSchedule() {
    	if (Auth::user()->accounttype == 10) {
            $applicants = Applicant::whereHas('qualificationcheck', function($query) {
                $query->where('status', 1);
            })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
                $query->where('clientid', Auth::user()->client->clientid);
            })->get();
        } else {
            $applicants = Applicant::whereHas('qualificationcheck', function($query) {
                $query->where('status', 1);
            })->whereHas('qualificationcheck.deploymentsite.managersite', function($query) {
                $query->where('managerid', Auth::user()->manager->managerid);
            })->get();
        }

    	return view('client.schedule', compact('applicants'));
    }

    public function getClientScheduleSecurityGuard(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        $deploymentsite = DeploymentSite::find($applicant->qualificationcheck->deploymentsiteid);
        $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
            $query->where([
                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                ['status', 1]
            ]);
        })->get();

        foreach ($applicants as $applicant) {
            if (!$applicant->schedule) {
                return Response::json("INPUT ALL DATE FIRST", 500);
            }
        }

        $sunday = false; $monday = false; $tuesday = false; $wednesday = false; $thursday = false; $friday = false; $saturday = false;
        foreach ($applicants as $applicant) {
            if ($applicant->schedule->sunday == 1) {
                $sunday = true;
            }
            if ($applicant->schedule->monday == 1) {
                $monday = true;
            }
            if ($applicant->schedule->tuesday == 1) {
                $tuesday = true;
            }
            if ($applicant->schedule->wednesday == 1) {
                $wednesday = true;
            }
            if ($applicant->schedule->thursday == 1) {
                $thursday = true;
            }
            if ($applicant->schedule->friday == 1) {
                $friday = true;
            }
            if ($applicant->schedule->saturday == 1) {
                $saturday = true;
            }
        }

        $begin = new DateTime($deploymentsite->contract->startdate);
        $end = new DateTime(Carbon::today()->addDays(1));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $date = Carbon::parse($dt->format('Y-m-d'));

            $schedulecheck = Schedule::whereHas('applicant.qualificationcheck', function($query) use ($deploymentsite) {
                $query->where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['status', 1]
                ]);
            })->orderBy('updated_at', 'desc')->first();

            if (new DateTime($date) < new DateTime($schedulecheck->updated_at)) {
                $attendance = Attendance::where('deploymentsiteid', $deploymentsite->deploymentsiteid)
                    ->whereDate('date', $date)->get();

                if (!$attendance->isEmpty()) {
                    
                }
            } else if ($sunday == false && $date->dayOfWeek == Carbon::SUNDAY) {

            } else if ($monday == false && $date->dayOfWeek == Carbon::MONDAY) {

            } else if ($tuesday == false && $date->dayOfWeek == Carbon::TUESDAY) {

            } else if ($wednesday == false && $date->dayOfWeek == Carbon::WEDNESDAY) {

            } else if ($thursday == false && $date->dayOfWeek == Carbon::THURSDAY) {

            } else if ($friday == false && $date->dayOfWeek == Carbon::FRIDAY) {

            } else if ($saturday == false && $date->dayOfWeek == Carbon::SATURDAY) {

            } else {
                if ($date->dayOfWeek == Carbon::SUNDAY) {
                    $dayname = 'sunday';
                } else if ($date->dayOfWeek == Carbon::MONDAY) {
                    $dayname = 'monday';
                } else if ($date->dayOfWeek == Carbon::TUESDAY) {
                    $dayname = 'tuesday';
                } else if ($date->dayOfWeek == Carbon::WEDNESDAY) {
                    $dayname = 'wednesday';
                } else if ($date->dayOfWeek == Carbon::THURSDAY) {
                    $dayname = 'thursday';
                } else if ($date->dayOfWeek == Carbon::FRIDAY) {
                    $dayname = 'friday';
                } else if ($date->dayOfWeek == Carbon::SATURDAY) {
                    $dayname = 'saturday';
                }

                $notset = Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $date->format('Y-m-d')]
                ])->get();
                $applicantno = count(Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                    $query->where([
                        ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                        ['status', 1]
                    ]);
                })->whereHas('schedule', function($query) use ($dayname) {
                    $query->where($dayname, 1);
                })->get());
                $attendanceno = count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $date->format('Y-m-d')],
                    ['timein', '!=', null],
                    ['timeout', '!=', null],
                    ['status', '!=', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 1],
                ])->get()) + count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $date->format('Y-m-d')],
                    ['status', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 2],
                ])->get());

                if ($notset->isEmpty()) {
                    return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                } else if ($applicantno == $attendanceno) {
                    
                } else {
                    return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                }
            }
        }

        $schedule = Schedule::where('applicantid', $request->inputApplicantID)->first();

        return Response::json($schedule);
    }

    public function postClientSchedule(Request $request) {
    	$applicant = Applicant::find($request->inputApplicantID);
        $schedule = Schedule::where('applicantid', $request->inputApplicantID)->first();

        if ($schedule == null) {
            $schedule = new Schedule;
            $schedule->applicant()->associate($applicant);
        }

        if ($request->inputSundayTimeIN != null && $request->inputSundayTimeOUT != null) {
            $schedule->sunday = true;
            $schedule->sundayin = $request->inputSundayTimeIN;
            $schedule->sundayout = $request->inputSundayTimeOUT;
        } else {
            $schedule->sunday = false;
        }
        if ($request->inputMondayTimeIN != null && $request->inputMondayTimeOUT != null) {
            $schedule->monday = true;
            $schedule->mondayin = $request->inputMondayTimeIN;
            $schedule->mondayout = $request->inputMondayTimeOUT;
        } else {
            $schedule->monday = false;
        }
        if ($request->inputTuesdayTimeIN != null && $request->inputTuesdayTimeOUT != null) {
            $schedule->tuesday = true;
            $schedule->tuesdayin = $request->inputTuesdayTimeIN;
            $schedule->tuesdayout = $request->inputTuesdayTimeOUT;
        } else {
            $schedule->tuesday = false;
        }
        if ($request->inputWednesdayTimeIN != null && $request->inputWednesdayTimeOUT != null) {
            $schedule->wednesday = true;
            $schedule->wednesdayin = $request->inputWednesdayTimeIN;
            $schedule->wednesdayout = $request->inputWednesdayTimeOUT;
        } else {
            $schedule->wednesday = false;
        }
        if ($request->inputThursdayTimeIN != null && $request->inputThursdayTimeOUT != null) {
            $schedule->thursday = true;
            $schedule->thursdayin = $request->inputThursdayTimeIN;
            $schedule->thursdayout = $request->inputThursdayTimeOUT;
        } else {
            $schedule->thursday = false;
        }
        if ($request->inputFridayTimeIN != null && $request->inputFridayTimeOUT != null) {
            $schedule->friday = true;
            $schedule->fridayin = $request->inputFridayTimeIN;
            $schedule->fridayout = $request->inputFridayTimeOUT;
        } else {
            $schedule->friday = false;
        }
        if ($request->inputSaturdayTimeIN != null && $request->inputSaturdayTimeOUT != null) {
            $schedule->saturday = true;
            $schedule->saturdayin = $request->inputSaturdayTimeIN;
            $schedule->saturdayout = $request->inputSaturdayTimeOUT;
        } else {
            $schedule->saturday = false;
        }
        $schedule->save();

    	return Response::json($schedule);
    }
}
