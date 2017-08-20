<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\DeploymentSite;
use Amcor\Applicant;
use Carbon\Carbon;
use Response;
use Auth;

class AttendanceController extends Controller
{
    public function getManagerAttendance() {
    	$deploymentsites = DeploymentSite::whereHas('managersite', function($query) {
    		$query->where('managerid', Auth::user()->manager->managerid);
    	})->whereHas('contract', function($query) {
    		$query->where([
				['startdate', '<=', Carbon::today()],
				['expiration', '>=', Carbon::today()],
			]);
    	})->get();

    	return view ('manager.attendance', compact('deploymentsites'));
    }

    public function getManagerSecurityGuard(Request $request) {
    	$deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);
    	$applicant = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsite) {
    		$query->where([
    			['status', 1],
    			['deployid', $deploymentsite->deploy->deployid],
    		]);
    	})->get();

    	return Response::json($applicant);
    }

    public function postManagerSecurityGuard(Request $request) {
    	$deploymentsite = DeploymentSite::find($request->inputDeploymentSiteID);

    	return Response::json($deploymentsite);
    }
}
