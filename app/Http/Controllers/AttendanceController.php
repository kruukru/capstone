<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Applicant;
use Amcor\Attendance;
use Amcor\Schedule;
use Carbon\Carbon;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;

class AttendanceController extends Controller
{
    //client client client client client client client client client client client client client client client client client client client 
    public function getClientAttendance() {
        if (Auth::user()->accounttype == 10) {
            $deploymentsites = DeploymentSite::where('status', 5)->whereHas('contract', function($query) {
                $query->where([
                    ['clientid', Auth::user()->client->clientid],
                    ['status', 0]
                ]);
            })->get();

            $applicants = Applicant::whereHas('attendance.deploymentsite.contract.client', function($query) {
                $query->where('clientid', Auth::user()->client->clientid);
            })->get();
        } else {
            $deploymentsites = DeploymentSite::where('status', 5)->whereHas('managersite', function($query) {
                $query->where('managerid', Auth::user()->manager->managerid);
            })->whereHas('contract', function($query) {
                $query->where('status', 0);
            })->get();

            $applicants = Applicant::whereHas('attendance.deploymentsite.managersite', function($query) {
                $query->where('managerid', Auth::user()->manager->managerid);
            })->get();
        }
        
        return view('client.attendance', compact('deploymentsites', 'applicants'));
    }

    public function getClientCalendar(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($request) {
            $query->where([
                ['deploymentsiteid', $request->inputDeploymentSiteID],
                ['status', 1]
            ]);
        })->get();

        $check = true;
        foreach ($applicants as $applicant) {
            if (!$applicant->schedule) {
                $check = false;
            }
        }

        if ($check) {
            $collection = collect();

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

                $schedulecheck = Schedule::whereHas('applicant.qualificationcheck', function($query) use ($request) {
                    $query->where([
                        ['deploymentsiteid', $request->inputDeploymentSiteID],
                        ['status', 1]
                    ]);
                })->orderBy('updated_at', 'desc')->first();

                if (new DateTime($date) < new DateTime($schedulecheck->updated_at)) {
                    $attendance = Attendance::where('deploymentsiteid', $request->inputDeploymentSiteID)
                        ->whereDate('date', $date)->get();

                    if (!$attendance->isEmpty()) {
                        $collection->push([
                            'title' => 'COMPLETE',
                            'date' => $date->format('Y-m-d'),
                            'status' => 0,
                        ]);
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
                        ['deploymentsiteid', $request->inputDeploymentSiteID],
                        ['date', $date->format('Y-m-d')]
                    ])->get();
                    $applicantno = count(Applicant::whereHas('qualificationcheck', function($query) use ($request) {
                        $query->where([
                            ['deploymentsiteid', $request->inputDeploymentSiteID],
                            ['status', 1]
                        ]);
                    })->whereHas('schedule', function($query) use ($dayname) {
                        $query->where($dayname, 1);
                    })->get());
                    $attendanceno = count(Attendance::where([
                        ['deploymentsiteid', $request->inputDeploymentSiteID],
                        ['date', $date->format('Y-m-d')],
                        ['timein', '!=', null],
                        ['timeout', '!=', null],
                        ['status', '!=', 2],
                        ['status', '>=', 0],
                        ['status', '<=', 1],
                    ])->get()) + count(Attendance::where([
                        ['deploymentsiteid', $request->inputDeploymentSiteID],
                        ['date', $date->format('Y-m-d')],
                        ['status', 2],
                        ['status', '>=', 0],
                        ['status', '<=', 2],
                    ])->get());

                    // if ($date->format('Y-m-d') == "2017-10-24") {
                    //     dd($applicantno . " - " . $attendanceno);
                    // }

                    if ($notset->isEmpty()) {
                        $collection->push([
                            'title' => 'NOT SET',
                            'date' => $date->format('Y-m-d'),
                            'status' => 2,
                        ]);
                    } else if ($applicantno == $attendanceno) {
                        $collection->push([
                            'title' => 'COMPLETE',
                            'date' => $date->format('Y-m-d'),
                            'status' => 0,
                        ]);
                    } else {
                        $collection->push([
                            'title' => 'INCOMPLETE',
                            'date' => $date->format('Y-m-d'),
                            'status' => 1,
                        ]);
                    }
                }
            }

            return Response::json($collection);
        } else {
            return Response::json("NO SCHEDULE", 500);
        }
    }

    public function getClientHistory(Request $request) {
        $attendance = Attendance::with('applicant')->where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['date', $request->inputDate]
        ])->get();

        return Response::json($attendance);
    }

    public function getClientSecurityGuard(Request $request) {
        $date = Carbon::parse($request->inputDate);
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
        $applicant1 = Applicant::with('schedule')->whereDate('updated_at', '<=', $date)
            ->whereHas('qualificationcheck', function($query) use ($request) {
                $query->where([
                    ['deploymentsiteid', $request->inputDeploymentSiteID],
                    ['status', 1]
                ]);
            })->whereHas('schedule', function($query) use ($dayname) {
                $query->where($dayname, 1);
            })->whereDoesntHave('attendance', function($query) use ($date) {
                $query->where('date', $date->format('Y-m-d'));
            })->whereDoesntHave('leaverequest', function($query) use ($date) {
                $query->whereDate('start', '<=', $date->format('Y-m-d'))
                    ->whereDate('end', '>=', $date->format('Y-m-d'));
            })->get();
        $applicant2 = Applicant::with('schedule')->whereHas('reliever', function($query) use ($request, $date) {
            $query->where([
                ['status', 0],
                ['deploymentsiteid', $request->inputDeploymentSiteID],
                ['date', $date->format('Y-m-d')],
                ['type', 'LEAVE']
            ]);
        })->whereDoesntHave('attendance', function($query) use ($date) {
            $query->where('date', $date->format('Y-m-d'));
        })->get();
        $applicant = $applicant1->merge($applicant2);

        $dataArray = array(
            'applicant' => $applicant,
            'dayofweek' => $date->dayOfWeek
        );

        return Response::json($dataArray);
    }

    public function getClientSecurityGuardOne(Request $request) {
        $attendance = Attendance::where([
            ['deploymentsiteid', $request->inputDeploymentSiteID],
            ['applicantid', $request->inputApplicantID],
            ['date', $request->inputDate]
        ])->first();

        if ($attendance == null) {
            return Response::json(400);
        }

        return Response::json($attendance);
    }

    public function postClientSecurityGuard(Request $request) {
        $deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
        $applicant = Applicant::find($request->inputApplicantID);
        $date = Carbon::parse($request->inputDate);

        $attendance = Attendance::where([
            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
            ['applicantid', $applicant->applicantid],
            ['date', $date]
        ])->first();

        $status = 0;
        if ($request->inputStatus == "late") {
            $status = 1;
        } else if ($request->inputStatus == "absent") {
            $status = 2;
        }

        if ($attendance == null) {
            $attendance = new Attendance;
            $attendance->deploymentsite()->associate($deploymentsite);
            $attendance->applicant()->associate($applicant);
            $attendance->date = $date;
            $attendance->timein = $request->inputTimeIN;
            $attendance->timeout = $request->inputTimeOUT;
            $attendance->reason = $request->inputReason;
            $attendance->status = $status;
        } else {
            $attendance->timein = $request->inputTimeIN;
            $attendance->timeout = $request->inputTimeOUT;
            $attendance->reason = $request->inputReason;
            $attendance->status = $status;
        }
        $attendance->save();

        return Response::json($attendance);
    }
}
