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

        $applicantreports = Applicant::whereHas('personinvolve')->get();
        $commends = collect();
        foreach ($applicantreports as $applicant) {
            $count = count(Report::where('violationid', null)->whereHas('personinvolve', function($query) use ($applicant) {
                $query->where('applicantid', $applicant->applicantid);
            })->get());
            $commends->push([
                'name' => $applicant->firstname . " " . $applicant->middlename . " " . $applicant->lastname,
                'count' => $count
            ]);
        }
        $violations = collect();
        foreach ($applicantreports as $applicant) {
            $count = count(Report::where('commendid', null)->whereHas('personinvolve', function($query) use ($applicant) {
                $query->where('applicantid', $applicant->applicantid);
            })->get());
            $violations->push([
                'name' => $applicant->firstname . " " . $applicant->middlename . " " . $applicant->lastname,
                'count' => $count
            ]);
        }

        $clientcontracts = Client::with('contract')->get();

        $deploymentsiteareas = DeploymentSite::groupBy('province', 'city')
            ->select('province', 'city', \DB::raw('count(*) as total'))->get();

        return view('admin.query.query', compact('scores', 'applicants', 'commends', 'violations', 'clientcontracts', 'deploymentsiteareas'));
    }
}
