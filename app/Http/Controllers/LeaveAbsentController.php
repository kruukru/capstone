<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Requestt;
use Amcor\DeploymentSite;
use Amcor\LeaveRequest;
use Carbon\Carbon;
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
}
