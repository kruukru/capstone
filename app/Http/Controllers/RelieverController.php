<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Reliever;
use Amcor\DeploymentSite;
use Carbon\Carbon;
use Auth;

class RelieverController extends Controller
{
    public function getApplicantReliever() {
    	$reliever = Reliever::whereDate('date', '>=', Carbon::today())
    		->where('applicantid', Auth::user()->applicant->applicantid)->first();
    	$deploymentsite = DeploymentSite::find($reliever->deploymentsiteid);

    	return view('applicant.reliever', compact('reliever', 'deploymentsite'));
    }
}
