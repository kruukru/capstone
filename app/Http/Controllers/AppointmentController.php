<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\AppointmentDate;
use Amcor\AppointmentSlot;
use Amcor\Appointment;
use Amcor\ApplicantRequirement;
use Carbon\Carbon;
use Response;
use Auth;

class AppointmentController extends Controller
{
    //applicant
    public function getApplicantAppointment() {
        $appointment = Appointment::with('AppointmentDate')
            ->where('applicantid', Auth::user()->applicant->applicantid)
            ->first();
        $applicantrequirements = ApplicantRequirement::with('Requirement')
            ->where([
                ['applicantid', Auth::user()->applicant->applicantid],
                ['issubmitted', 0],
            ])->get();

    	return view('applicant.appointment', compact('appointment', 'applicantrequirements'));
    }

    public function getApplicantAppointmentDate() {
        $appointmentdates = AppointmentDate::where('date', '>=', Carbon::today())->get();
        $appointmentslot = AppointmentSlot::first();
        $collection = collect();

        foreach ($appointmentdates as $appointmentdate) {
            $availableslot = $appointmentslot->slot;
            if(!($appointmentdate->appointment->isEmpty())) {
                $availableslot -= $appointmentdate->appointment->count();
            }

            if($availableslot != 0) {
                if ($appointmentdate->holiday == null) {
                    $collection->push([
                        'id' => $appointmentdate->appointmentdateid,
                        'title' => $availableslot . ' SLOT(S)',
                        'date' => $appointmentdate->date->format("Y-m-d"),
                        'holiday' => 0,
                    ]);
                } else {
                    $collection->push([
                        'id' => $appointmentdate->appointmentdateid,
                        'title' => $appointmentdate->holiday->name,
                        'date' => $appointmentdate->date->format("Y-m-d"),
                        'holiday' => 1,
                    ]);
                }
            }
        }

        return Response::json($collection);
    }

    public function postApplicantAppointment(Request $request) {
        $appointment = new Appointment;
        $appointment->applicantid = Auth::user()->applicant->applicantid;
        $appointment->appointmentdateid = $request->inputAppointmentDateID;
        $appointment->save();

        return Response::json($appointment);
    }

    public function postApplicantRemove(Request $request) {
        $appointment = Appointment::find($request->inputAppointmentDateID);
        $appointment->delete();

        return Response::json($appointment);
    }

    //sign up
    public function getSignUpAppointmentDate() {
        $appointmentdates = AppointmentDate::where('date', '>=', Carbon::today())->get();
        $appointmentslot = AppointmentSlot::first();
        $collection = collect();

        foreach ($appointmentdates as $appointmentdate) {
            $availableslot = $appointmentslot->slot;
            if(!($appointmentdate->appointment->isEmpty())) {
                $availableslot -= $appointmentdate->appointment->count();
            }

            if($availableslot != 0) {
                if ($appointmentdate->holiday == null) {
                    $collection->push([
                        'id' => $appointmentdate->appointmentdateid,
                        'title' => $availableslot . ' SLOT(S)',
                        'date' => $appointmentdate->date->format("Y-m-d"),
                        'holiday' => 0,
                    ]);
                } else {
                    $collection->push([
                        'id' => $appointmentdate->appointmentdateid,
                        'title' => $appointmentdate->holiday->name,
                        'date' => $appointmentdate->date->format("Y-m-d"),
                        'holiday' => 1,
                    ]);
                }
            }
        }

        return Response::json($collection);
    }

    public function postSignUpAppointment(Request $request) {
        $appointment = new Appointment;
        $appointment->applicantid = Auth::user()->applicant->applicantid;
        $appointment->appointmentslotid = $request->inputAppointmentSlotID;
        $appointment->save();

        return Response::json($appointment);
    }
}
