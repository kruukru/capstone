<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Contract;
use Amcor\Applicant;
use Amcor\Appointment;
use Amcor\ApplicantRequirement;
use Amcor\Score;
use Amcor\Attendance;
use Amcor\DeploymentSite;
use Amcor\Report;
use Carbon\Carbon;
use PDF;
use Auth;

class PDFController extends Controller
{
    //admin
    public function getAdminContractDocument($contractid) {
        $contract = Contract::with('client', 'deploymentsite')->find($contractid);

        if ($contract == null) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('admin.pdf.contract', compact('contract'));
        return $pdf->stream();
    }

    public function getAdminTestResultDocument($applicantid) {
        $applicant = Applicant::find($applicantid);
        $scores = Score::where([
            ['applicantid', $applicantid],
            ['item', '!=', 0],
        ])->get();

        if ($applicant == null || $scores->isEmpty()) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('admin.pdf.testresult', compact('applicant', 'scores'));
        return $pdf->stream();
    }

    public function getAdminReportCertificate(Request $request) {
        $applicants = Applicant::whereHas('personinvolve', function($query) use ($request) {
            $query->where('reportid', $request->input('certificatereportid'));
        })->get();
        $certificatedescription = $request->input('certificatedescription');

        $pdf = PDF::loadView('admin.pdf.certificate', compact('applicants', 'certificatedescription'));
        return $pdf->stream();
    }

    public function getAdminReportMemorandum(Request $request) {
        $applicants = Applicant::with('qualificationcheck.deploymentsite')->whereHas('personinvolve', function($query) use ($request) {
            $query->where('reportid', $request->input('memorandumreportid'));
        })->get();
        $subject = $request->input('subject');
        $memorandumbody = $request->input('memorandumbody');

        $pdf = PDF::loadView('admin.pdf.memorandum', compact('applicants', 'subject', 'memorandumbody'));
        return $pdf->stream();
    }

    //manager
    public function getManagerAttendanceDocument($deploymentsiteid) {
        $deploymentsite = DeploymentSite::find($deploymentsiteid);
        $attendances = Attendance::where([
            ['deploymentsiteid', $deploymentsiteid],
            ['date', Carbon::today()],
        ])->orderBy('status')->get();

        if ($deploymentsite == null) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('manager.pdf.attendance', compact('attendances', 'deploymentsite'));
        return $pdf->stream();
    }

    //applicant
    public function getApplicantAppointmentVoucher() {
    	$applicant = Applicant::find(Auth::user()->applicant->applicantid);
    	$applicantrequirements = ApplicantRequirement::with('Requirement')
    		->where('applicantid', Auth::user()->applicant->applicantid)
    		->get();
    	$appointment = Appointment::with('AppointmentDate')
    		->where('applicantid', Auth::user()->applicant->applicantid)
    		->first();

	    $pdf = PDF::loadView('applicant.pdf.appointmentvoucher', compact('applicant', 'appointment', 'applicantrequirements'));
	    return $pdf->stream();
    }
}
