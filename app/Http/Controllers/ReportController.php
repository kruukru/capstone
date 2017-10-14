<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Firearm;
use Amcor\Applicant;
use Amcor\Item;
use Amcor\Report;
use Amcor\Commend;
use Amcor\Violation;
use Amcor\PersonInvolve;
use Carbon\Carbon;
use PDF;
use Auth;
use Response;

class ReportController extends Controller
{
    //client client client client client client client client client client client client client client client client client client client client client 
    public function getClientReport() {
        if (Auth::user()->accounttype == 10) {
            $partone = Report::where('accountid', Auth::user()->accountid)->get();
            $parttwo = Report::whereHas('account.manager', function($query) {
                $query->where('clientid', Auth::user()->client->clientid);
            })->get();
            $reports = $partone->merge($parttwo);
        } else {
            $partone = Report::whereHas('account.client', function($query) {
                $query->where('clientid', Auth::user()->manager->clientid);
            })->get();
            $parttwo = Report::whereHas('account.manager', function($query) {
                $query->where('clientid', Auth::user()->manager->clientid);
            })->get();
            $reports = $partone->merge($parttwo);
        }

        return view('client.report', compact('reports'));
    }

    public function getClientSecurityGuard() {
        if (Auth::user()->accounttype == 10) {
            $applicant = Applicant::with('qualificationcheck.deploymentsite')->whereHas('qualificationcheck', function($query) {
                $query->where('status', 1);
            })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
                $query->where('clientid', Auth::user()->client->clientid);
            })->get();
        } else {
            $applicant = Applicant::with('qualificationcheck.deploymentsite')->whereHas('qualificationcheck', function($query) {
                $query->where('status', 1);
            })->whereHas('qualificationcheck.deploymentsite.managersite', function($query) {
                $query->where('managerid', Auth::user()->manager->managerid);
            })->get();
        }

        return Response::json($applicant);
    }

    public function postClientReportNew(Request $request) {
        $report = new Report;
        $report->account()->associate(Auth::user());
        if ($request->inputReportStatus == 0) {
            $commend = Commend::find($request->inputReportType);
            $report->commend()->associate($commend);
        } else {
            $violation = Violation::find($request->inputReportType);
            $report->violation()->associate($violation);
        }
        $report->placehappen = $request->inputPlaceHappen;
        $report->subject = $request->inputSubject;
        $report->detail = $request->inputDetail;
        $report->date = Carbon::today();
        $report->save();

        foreach ($request->formData as $data) {
            $applicant = Applicant::find($data['inputApplicantID']);
            $personinvolve = new PersonInvolve;
            $personinvolve->report()->associate($report);
            $personinvolve->applicant()->associate($applicant);
            $personinvolve->save();
        }

        $rep = Report::with('commend', 'violation', 'personinvolve.applicant')->find($report->reportid);

        return Response::json($rep);
    }

    public function postClientReportUpdate(Request $request) {
        $report = Report::find($request->inputReportID);
        $report->placehappen = $request->inputPlaceHappen;
        $report->subject = $request->inputSubject;
        $report->detail = $request->inputDetail;
        $report->save();

        return Response::json($report);
    }

    public function postClientReportRemove(Request $request) {
        PersonInvolve::where('reportid', $request->inputReportID)->forceDelete();
        Report::find($request->inputReportID)->forceDelete();

        return Response::json(400);
    }

    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
    public function getAdminReport() {
        $reports = Report::get();

        return view('admin.transaction.report', compact('reports'));
    }

    public function getAdminSecurityGuard() {
        $applicant = Applicant::with('qualificationcheck.deploymentsite')->whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->get();

        return Response::json($applicant);
    }

    public function postAdminReportNew(Request $request) {
        $report = new Report;
        $report->account()->associate(Auth::user());
        if ($request->inputReportStatus == 0) {
            $commend = Commend::find($request->inputReportType);
            $report->commend()->associate($commend);
        } else {
            $violation = Violation::find($request->inputReportType);
            $report->violation()->associate($violation);
        }
        $report->placehappen = $request->inputPlaceHappen;
        $report->subject = $request->inputSubject;
        $report->detail = $request->inputDetail;
        $report->date = Carbon::today();
        $report->save();

        foreach ($request->formData as $data) {
            $applicant = Applicant::find($data['inputApplicantID']);
            $personinvolve = new PersonInvolve;
            $personinvolve->report()->associate($report);
            $personinvolve->applicant()->associate($applicant);
            $personinvolve->save();
        }

        $rep = Report::with('commend', 'violation', 'personinvolve.applicant')->find($report->reportid);

        return Response::json($rep);
    }

    public function postAdminReportUpdate(Request $request) {
        $report = Report::find($request->inputReportID);
        $report->placehappen = $request->inputPlaceHappen;
        $report->subject = $request->inputSubject;
        $report->detail = $request->inputDetail;
        $report->save();

        return Response::json($report);
    }

    public function postAdminReportRemove(Request $request) {
        PersonInvolve::where('reportid', $request->inputReportID)->forceDelete();
        Report::find($request->inputReportID)->forceDelete();

        return Response::json(400);
    }
}
