<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;

class LeaveAbsentController extends Controller
{
	//applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant 
    public function getApplicantLeave() {
    	return view('applicant.leave');
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

        return Response::json(400);
    }

    public function getApplicantLeaveCancel() {
        LeaveRequest::where('applicantid', Auth::user()->applicant->applicantid)->forceDelete();
        Requestt::where('accountid', Auth::user()->accountid)->forceDelete();

        return Response::json(400);
    }
}
