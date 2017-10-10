<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\QualificationCheck;
use Amcor\Account;
use Amcor\ReplaceApplicant;
use Amcor\DeploymentSite;
use Amcor\Attendance;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;
use Response;

class SecurityGuardController extends Controller
{
    public function getAdminSecurityGuard() {
    	$applicants = Applicant::get();

    	return view('admin.transaction.securityguard', compact('applicants'));
    }

    //client client client client client client client client client client client client client client client client client client client client client
    public function getClientSecurityGuard() {
    	$applicants = Applicant::whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

        return view('client.securityguard', compact('applicants'));
    }

    public function postClientSecurityGuardReplace(Request $request) {
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
            if ($sunday == false && $date->dayOfWeek == Carbon::SUNDAY) {

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
                    ['date', $dt->format('Y-m-d')]
                ])->get();
                $applicantno = count(Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                    $query->where([
                        ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                        ['status', 1]
                    ]);
                })->whereHas('schedule', function($query) use ($dayname, $date) {
                    $query->where($dayname, 1);
                })->get());
                $attendanceno = count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $dt->format('Y-m-d')],
                    ['timein', '!=', null],
                    ['timeout', '!=', null],
                    ['status', '!=', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 1],
                ])->get()) + count(Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['date', $dt->format('Y-m-d')],
                    ['status', 2],
                    ['status', '>=', 0],
                    ['status', '<=', 2],
                ])->get());

                if ($notset->isEmpty()) {
                    $applicantcheck = Applicant::whereDate('updated_at', '<=', $date)
                        ->whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                            $query->where([
                                ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                                ['status', 1]
                            ]);
                        })->whereHas('schedule', function($query) use ($dayname, $date) {
                            $query->where($dayname, 1)
                                ->whereDate('updated_at', '<=', $date);
                        })->whereDoesntHave('attendance', function($query) use ($date) {
                            $query->where('date', $date->format('Y-m-d'));
                        })->get();

                    if (!$applicantcheck->isEmpty()) {
                        return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                    }
                } else if ($applicantno == $attendanceno) {
                    
                } else {
                    $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
                        $query->where([
                            ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                            ['status', 1]
                        ]);
                    })->get();

                    $checkdate = false;
                    foreach ($applicants as $applicant) {
                        if (new DateTime($applicant->schedule->updated_at) >= new DateTime($date)) {
                            $checkdate = true;
                        }
                    }

                    if ($checkdate) {

                    } else {
                        return Response::json("COMPLETE ATTENDANCE FIRST", 500);
                    }
                }
            }
        }

    	$qualificationcheck = QualificationCheck::where('applicantid', $request->inputApplicantID)->first();

    	$replaceapplicant = new ReplaceApplicant;
    	$replaceapplicant->qualificationcheck()->associate($qualificationcheck);
    	$replaceapplicant->account()->associate(Auth::user());
    	$replaceapplicant->reason = $request->inputReason;
    	$replaceapplicant->status = 0;
    	$replaceapplicant->save();

    	return Response::json($replaceapplicant);
    }

    public function postClientSecurityGuardReplaceCancel(Request $request) {
        ReplaceApplicant::whereHas('qualificationcheck', function($query) use ($request) {
            $query->where('applicantid', $request->inputApplicantID);
        })->forceDelete();

        return Response::json(400);
    }
}
