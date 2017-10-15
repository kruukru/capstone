<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Score;
use Amcor\Client;
use Amcor\Applicant;
use Amcor\DeploymentSite;
use Amcor\PersonInvolve;
use Amcor\Report;

class QueryController extends Controller
{
    public function getAdminQuery() {
        $scores = Score::with('applicant')->get();

        $applicants = Applicant::where('lastdeployed', '!=', null)->get();

        $commends = Applicant::whereHas('personinvolve.report', function($query) {
            $query->where('commendid', '!=', null);
        })->get();

        $violations = Applicant::whereHas('personinvolve.report', function($query) {
            $query->where('violationid', '!=', null);
        })->get();

        $clientcontracts = Client::with('contract')->get();

        $deploymentsiteareas = DeploymentSite::groupBy('province', 'city')
            ->select('province', 'city', \DB::raw('count(*) as total'))->get();

        return view('admin.query.query', compact('scores', 'applicants', 'commends', 'violations', 'clientcontracts', 'deploymentsiteareas'));
    }
}
