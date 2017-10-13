<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Appointment;
use Amcor\Holiday;
use Amcor\Applicant;
use Amcor\Contract;
use Amcor\Requestt;
use Amcor\IssuedItem;
use Amcor\IssuedFirearm;
use Amcor\Item;
use Amcor\QualificationCheck;
use Amcor\Schedule;
use Amcor\Client;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Auth;
use Response;

class HomeController extends Controller
{
    public function index() {
        //for appointment
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
        })->whereHas('applicant', function($query) {
            $query->where('status', 0);
        })->forceDelete();
        Appointment::whereHas('appointmentdate', function($query) use ($appointmentslot) {
            $query->where('date', '>=', Carbon::today()->addDays($appointmentslot->noofday));
        })->forceDelete();
        
        AppointmentDate::where('date', '<', Carbon::today())
            ->whereDoesntHave('appointment')->forceDelete();
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

        //for expiring of contract
        $contracts = Contract::where('status', 0)
            ->whereDate('expiration', '<=', Carbon::today())->get();

        foreach ($contracts as $contract) {
            $issueditems = IssuedItem::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->get();
            foreach ($issueditems as $issueditem) {
                IssuedFirearm::where('issueditemid', $issueditem->issueditemid)->forceDelete();
                $item = Item::find($issueditem->itemid);
                $item->qty += $issueditem->qty;
                $item->qtyavailable += $issueditem->qty;
                $item->save();
            }

            $qualificationchecks = QualificationCheck::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->get();
            foreach ($qualificationchecks as $qualificationcheck) {
                $applicant = Applicant::find($qualificationcheck->applicantid);
                $applicant->lastdeployed = Carbon::today();
                $applicant->status = 8;
                $applicant->save();

                Schedule::where('applicantid', $applicant->applicantid)->forceDelete();
            }
            QualificationCheck::where('deploymentsiteid', $contract->deploymentsite->deploymentsiteid)->forceDelete();

            $contract->status = 1;
            $contract->save();

            $clientstatus = Contract::where([
                ['clientid', $contract->clientid],
                ['status', 0]
            ])->get();

            if ($clientstatus->isEmpty()) {
                $client = Client::find($contract->clientid);
                $client->status = 0;
                $client->save();
            }
        }

    	if (Auth::check()) {
    		if (Auth::user()->accounttype == 0) {
                return view('admin.executivehome');
	    	} else if (Auth::user()->accounttype == 1) {
                return view('admin.adminhome');
            } else if (Auth::user()->accounttype == 2) {
                return view('admin.operationhome');
            } else if (Auth::user()->accounttype == 3) {
                $unscheduledapplicants = count(Applicant::where('status', 0)->doesntHave('appointment')->get());
                $onappointment = count(Appointment::whereHas('applicant', function($query) {
                    $query->where('status', 0);
                })->get());
                $testingandinterview = count(Applicant::where([
                    ['status', '>=', 1],
                    ['status', '<=', 3]
                ])->orWhere([
                    ['status', '>=', 5],
                    ['status', '<=', 7]
                ])->get());
                $incompletecredentials = count(Applicant::where([
                    ['status', '>=', 1],
                    ['status', '<=', 5]
                ])->get());

                $applicants = Applicant::get();
                $requests = Requestt::where('status', 0)->get();

                return view('admin.hrhome', compact('unscheduledapplicants', 'onappointment', 'testingandinterview', 'incompletecredentials', 'applicants', 'requests'));
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

    public function getAdminHRDashboard() {
        $deployed = count(Applicant::where('status', 10)->get());
        $pooling = count(Applicant::where('status', 8)->get());
        $application = count(Applicant::where([
            ['status', '>=', 0],
            ['status', '<=', 7]
        ])->get());
        $status = array($deployed, $pooling, $application);

        $mostpriority = 0; $leastpriority = 0;
        $applicants = Applicant::where([
            ['status', 8],
            ['lastdeployed', '<=', Carbon::today()->addDays(-30)]
        ])->get();
        foreach ($applicants as $applicant) {
            if ($applicant->lastdeployed->diffInDays(Carbon::today()) >= 60) {
                $mostpriority++;
            } else {
                $leastpriority++;
            }
        }
        $priority = array($mostpriority, $leastpriority);

        $dataArray = array(
            'status' => $status,
            'priority' => $priority,
        );

        return Response::json($dataArray);
    }
}
