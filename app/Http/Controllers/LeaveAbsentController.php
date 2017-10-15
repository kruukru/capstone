<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Requestt;
use Amcor\DeploymentSite;
use Amcor\LeaveRequest;
use Amcor\Applicant;
use Amcor\Reliever;
use Amcor\RelieverLeave;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Response;
use Auth;

class LeaveAbsentController extends Controller
{
	//applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant 
    public function getApplicantLeave() {
        $leaverequests = LeaveRequest::where('applicantid', Auth::user()->applicant->applicantid)->get();

    	return view('applicant.leave', compact('leaverequests'));
    }

    public function getApplicantRequestLeave(Request $request) {
        $deploymentsite = DeploymentSite::find(Auth::user()->applicant->qualificationcheck->deploymentsite->deploymentsiteid);

        $requestt = new Requestt;
        $requestt->deploymentsite()->associate($deploymentsite);
        $requestt->account()->associate(Auth::user());
        $requestt->type = "LEAVE";
        $requestt->datecreated = Carbon::today();
        $requestt->status = 0;
        $requestt->save();

        $leaverequest = new LeaveRequest;
        $leaverequest->request()->associate($requestt);
        $leaverequest->applicant()->associate(Auth::user()->applicant);
        $leaverequest->start = $request->inputStartDate;
        $leaverequest->end = $request->inputEndDate;
        $leaverequest->reason = $request->inputReason;
        $leaverequest->save();

        return Response::json($leaverequest);
    }

    public function getApplicantLeaveCancel(Request $request) {
        $leaverequest = LeaveRequest::find($request->inputLeaveRequestID);
        $leaverequest->forceDelete();
        $leaverequest->request->forceDelete();

        return Response::json($leaverequest);
    }

    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin
    public function getAdminLeaveAbsent() {
        $leaverequests = LeaveRequest::get();

        return view('admin.transaction.leaveabsent', compact('leaverequests'));
    }

    public function getAdminLeaveAbsentReliever() {
        $applicants = Applicant::where('status', 8)->get();

        $pool = collect();
        foreach ($applicants as $applicant) {
            $pool->push([
                'applicantid' => $applicant->applicantid,
                'name' => $applicant->firstname . " " . $applicant->middlename . " " . $applicant->lastname,
                'vacant' => $applicant->lastdeployed->diffInDays(Carbon::today())
            ]);
        }

        return Response::json($pool);
    }

    public function postAdminLeaveReliever(Request $request) {
        $leaverequest = LeaveRequest::find($request->inputLeaveRequestID);
        $applicant = Applicant::find($request->inputApplicantRelieverID);

        $leaverequest->request->status = 1;
        $leaverequest->request->save();

        $applicant->status = 11;
        $applicant->save();

        $begin = new DateTime($leaverequest->start);
        $end = new DateTime($leaverequest->end->addDays(1));
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        foreach ($period as $dt) {
            $reliever = new Reliever;
            $reliever->applicant()->associate($applicant);
            $reliever->type = "LEAVE";
            $reliever->date = $dt->format('Y-m-d');
            $reliever->status = 0;
            $reliever->save();

            $relieverleave = new RelieverLeave;
            $relieverleave->reliever()->associate($reliever);
            $relieverleave->leaverequest()->associate($leaverequest);
            $relieverleave->save();
        }

        return Response::json($leaverequest);
    }

    public function postAdminLeaveDecline(Request $request) {
        $leaverequest = LeaveRequest::find($request->inputLeaveRequestID);
        $leaverequest->request->status = 2;
        $leaverequest->request->save();

        return Response::json($leaverequest);
    }
}
