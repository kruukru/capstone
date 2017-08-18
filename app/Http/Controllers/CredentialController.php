<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Appointment;
use Amcor\Applicant;
use Amcor\ApplicantRequirement;
use Amcor\Requirement;
use Carbon\Carbon;
use Response;

class CredentialController extends Controller
{
    public function getAdminSubmitCredential() {
    	$applicants = Applicant::where('status', '<=', 4)
                ->whereHas('Appointment', function($query) {
                    $query->whereHas('AppointmentDate', function($query) {
                        $query->where('date', '<=', Carbon::today());
                    });
                })->get();

    	return view('admin.transaction.submitcredential', compact('applicants'));
    }

    public function getAdminApplicantRequirement(Request $request) {
        $applicantrequirement = ApplicantRequirement::with('Requirement')
            ->where('applicantid', $request->inputApplicantID)
            ->get();

        return Response::json($applicantrequirement);
    }

    public function postAdminRequirementPass(Request $request) {
        $applicantrequirement = ApplicantRequirement::with('Requirement')
            ->where('applicantid', $request->inputApplicantID)
            ->find($request->inputApplicantRequirementID);

        $applicantrequirement->issubmitted = 1;
        $applicantrequirement->save();

        return Response::json($applicantrequirement);
    }

    public function postAdminRequirementRemove(Request $request) {
        $applicantrequirement = ApplicantRequirement::with('Requirement')
            ->where('applicantid', $request->inputApplicantID)
            ->find($request->inputApplicantRequirementID);

        $applicantrequirement->issubmitted = 0;
        $applicantrequirement->save();

        return Response::json($applicantrequirement);
    }

    public function postAdminRequirementAssess(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);

        if ($request->inputStatus == 0) {
            if ($applicant->status == 0) {
                $applicant->status = 5;
            } else {
                $applicant->status += 4;
            }
        } else {
            if ($applicant->status == 0) {
                $applicant->status = 1;
            }
        }
        $applicant->save();

        return Response::json($applicant);
    }

    public function postAdminPersonalInfo(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        
    }
}
