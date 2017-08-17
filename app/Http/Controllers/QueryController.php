<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Score;
use Amcor\Client;
use Amcor\Applicant;
use Amcor\DeploymentSite;

class QueryController extends Controller
{
    public function getAdminSecurityGuardScore() {
    	$scores = Score::with('Applicant')->get();

    	return view('admin.query.securityguardscore', compact('scores'));
    }

    public function getAdminSecurityGuardVacant() {
    	$applicants = Applicant::get();

    	return view('admin.query.securityguardvacant', compact('applicants'));
    }

    public function getAdminSecurityGuardCommend() {
    	return view('admin.query.securityguardcommend');
    }

    public function getAdminSecurityGuardViolation() {
    	return view('admin.query.securityguardviolation');
    }

    public function getAdminClientContract() {
    	$clients = Client::with('Contract')->get();

    	return view('admin.query.clientcontract', compact('clients'));
    }

    public function getAdminDeploymentSiteArea() {
    	$deploymentsites = DeploymentSite::groupBy('province', 'city')
    		->select('province', 'city', \DB::raw('count(*) as total'))->get();

    	return view('admin.query.deploymentsitearea', compact('deploymentsites'));
    }
}
