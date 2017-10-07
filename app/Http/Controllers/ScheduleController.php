<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\Schedule;
use Response;
use Auth;

class ScheduleController extends Controller
{
    public function getClientSchedule() {
    	$applicants = Applicant::whereHas('qualificationcheck', function($query) {
            $query->where('status', 1);
        })->whereHas('qualificationcheck.deploymentsite.contract', function($query) {
            $query->where('clientid', Auth::user()->client->clientid);
        })->get();

    	return view('client.schedule', compact('applicants'));
    }

    public function postClientSchedule(Request $request) {
    	$applicant = Applicant::find($request->inputApplicantID);

    	$schedule = new Schedule;
    	$schedule->applicant()->associate($applicant);
    	if ($request->inputSundayTimeIN != null && $request->inputSundayTimeOUT != null) {
    		$schedule->sunday = true;
    		$schedule->sundayin = $request->inputSundayTimeIN;
    		$schedule->sundayout = $request->inputSundayTimeOUT;
    	} else {
    		$schedule->sunday = false;
    	}
    	if ($request->inputMondayTimeIN != null && $request->inputMondayTimeOUT != null) {
    		$schedule->monday = true;
    		$schedule->mondayin = $request->inputMondayTimeIN;
    		$schedule->mondayout = $request->inputMondayTimeOUT;
    	} else {
    		$schedule->monday = false;
    	}
    	if ($request->inputTuesdayTimeIN != null && $request->inputTuesdayTimeOUT != null) {
    		$schedule->tuesday = true;
    		$schedule->tuesdayin = $request->inputTuesdayTimeIN;
    		$schedule->tuesdayout = $request->inputTuesdayTimeOUT;
    	} else {
    		$schedule->tuesday = false;
    	}
    	if ($request->inputWednesdayTimeIN != null && $request->inputWednesdayTimeOUT != null) {
    		$schedule->wednesday = true;
    		$schedule->wednesdayin = $request->inputWednesdayTimeIN;
    		$schedule->wednesdayout = $request->inputWednesdayTimeOUT;
    	} else {
    		$schedule->wednesday = false;
    	}
    	if ($request->inputThursdayTimeIN != null && $request->inputThursdayTimeOUT != null) {
    		$schedule->thursday = true;
    		$schedule->thursdayin = $request->inputThursdayTimeIN;
    		$schedule->thursdayout = $request->inputThursdayTimeOUT;
    	} else {
    		$schedule->thursday = false;
    	}
    	if ($request->inputFridayTimeIN != null && $request->inputFridayTimeOUT != null) {
    		$schedule->friday = true;
    		$schedule->fridayin = $request->inputFridayTimeIN;
    		$schedule->fridayout = $request->inputFridayTimeOUT;
    	} else {
    		$schedule->friday = false;
    	}
    	if ($request->inputSaturdayTimeIN != null && $request->inputSaturdayTimeOUT != null) {
    		$schedule->saturday = true;
    		$schedule->saturdayin = $request->inputSaturdayTimeIN;
    		$schedule->saturdayout = $request->inputSaturdayTimeOUT;
    	} else {
    		$schedule->saturday = false;
    	}
    	$schedule->save();

    	return Response::json($schedule);
    }
}
