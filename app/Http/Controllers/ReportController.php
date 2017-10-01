<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Firearm;
use Amcor\Applicant;
use Amcor\Item;
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
        return view('client.report');
    }

    public function getClientSecurityGuard() {
        $applicant = Applicant::with('qualificationcheck.deploymentsite')->whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

        return Response::json($applicant);
    }
}
