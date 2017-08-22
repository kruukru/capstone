<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Applicant;
use Amcor\Attendance;
use Carbon\Carbon;
use Response;
use Auth;

class AttendanceController extends Controller
{
    public function getManagerAttendance() {
    	$deploymentsites = DeploymentSite::where('status', 3)->whereHas('managersite', function($query) {
    		$query->where('managerid', Auth::user()->manager->managerid);
    	})->whereHas('contract', function($query) {
    		$query->where([
				['startdate', '<=', Carbon::today()],
				['expiration', '>=', Carbon::today()],
			]);
    	})->whereDoesntHave('attendance', function($query) {
            $query->where('date', Carbon::today());
        })->get();

    	return view ('manager.attendance', compact('deploymentsites'));
    }

    public function getManagerSecurityGuard(Request $request) {
    	$deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
    	$applicant = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
    		$query->where([
    			['status', 1],
    			['deploymentsiteid', $deploymentsite->deploymentsiteid],
    		]);
    	})->get();

    	return Response::json($applicant);
    }

    public function postManagerSecurityGuard(Request $request) {
    	$deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

        foreach ($request->formData as $data) {
            $applicant = Applicant::find($data['inputApplicantID']);

            $attendance = new Attendance;
            $attendance->deploymentsite()->associate($deploymentsite);
            $attendance->applicant()->associate($applicant);
            $attendance->date = Carbon::today();
            if ($data['inputStatus'] == "Present") {
                $attendance->status = 0;
            } else if ($data['inputStatus'] == "Late") {
                $attendance->status = 1;
            } else if ($data['inputStatus'] == "Absent") {
                $attendance->status = 2;
            }
            $attendance->save();
        }

    	return Response::json($deploymentsite);
    }
}
