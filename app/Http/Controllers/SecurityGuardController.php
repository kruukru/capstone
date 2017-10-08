<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\QualificationCheck;
use Amcor\Account;
use Amcor\ReplaceApplicant;
use Auth;
use Response;

class SecurityGuardController extends Controller
{
    public function getAdminSecurityGuard() {
    	$applicants = Applicant::get();

    	return view('admin.transaction.securityguard', compact('applicants'));
    }

    //client client client client client client client client client client client client client client client client client client client client client
    public function getClientSecurityGuard() {
    	$applicants = Applicant::whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

        return view('client.securityguard', compact('applicants'));
    }

    public function postClientSecurityGuardReplace(Request $request) {
    	$qualificationcheck = QualificationCheck::where('applicantid', $request->inputApplicantID)->first();

    	$replaceapplicant = new ReplaceApplicant;
    	$replaceapplicant->qualificationcheck()->associate($qualificationcheck);
    	$replaceapplicant->account()->associate(Auth::user());
    	$replaceapplicant->reason = $request->inputReason;
    	$replaceapplicant->status = 0;
    	$replaceapplicant->save();

    	return Response::json($replaceapplicant);
    }

    public function postClientSecurityGuardReplaceCancel(Request $request) {
        ReplaceApplicant::whereHas('qualificationcheck', function($query) use ($request) {
            $query->where('applicantid', $request->inputApplicantID);
        })->forceDelete();

        return Response::json(400);
    }
}
