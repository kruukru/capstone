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
    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
    public function getAdminFirearmLicense() {
    	$firearms = Firearm::with('Item')
    		->orderBy('expiration')->get();

    	$pdf = PDF::loadView('admin.report.firearmlicense', compact('firearms'));
        return $pdf->stream();
    }

    public function getAdminSecurityLicense() {
    	$applicants = Applicant::orderBy('licenseexpiration')->get();

    	$pdf = PDF::loadView('admin.report.securitylicense', compact('applicants'));
    	return $pdf->stream();
    }

    public function getAdminEquipment() {
    	$items = Item::get();

    	$pdf = PDF::loadView('admin.report.equipment', compact('items'));
    	return $pdf->stream();
    }

    public function getAdminDDO() {
    	$pdf = PDF::loadView('admin.report.ddo');
    	return $pdf->stream();
    }

    public function getAdminMDR() {
    	$pdf = PDF::loadView('admin.report.mdr');
    	return $pdf->stream();
    }

    //client client client client client client client client client client client client client client client client client client client client client 
    public function getClientReport() {
        $reports = Report::where('accountid', Auth::user()->accountid)->get();

        return view('client.report', compact('reports'));
    }

    public function getClientSecurityGuard() {
        $applicant = Applicant::with('qualificationcheck.deploymentsite')->whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

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
}
