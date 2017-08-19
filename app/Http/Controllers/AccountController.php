<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Account;
use Amcor\Applicant;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Appointment;
use Amcor\Requirement;
use Amcor\ApplicantRequirement;
use Amcor\EducationBackground;
use Amcor\EmploymentRecord;
use Amcor\TrainingCertificate;
use Auth;
use Response;
use PDF;

class AccountController extends Controller
{
    //sign in
    public function getSignIn() {
    	return view('index.signin');
    }

    public function postSignIn(Request $request) {
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required',
    	]);

    	if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('home');
        } else {
        	return redirect()->back()->with('info', 'INVALID USERNAME/PASSWORD');
        }
    }

    //sign up
    public function getSignUp() {
        return view('index.signup');
    }

    public function postSignUp(Request $request) {
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        $appointmentdate = AppointmentDate::find($request->inputAppointmentDateID);
        if ($appointmentdate == null) {
            return Response::json("APPOINTMENT CHANGED", 500);
        }
        if ($appointmentdate->holidayid != null) {
            return Response::json("APPOINTMENT CHANGED", 500);
        }
        if (AppointmentSlot::first()->slot <= count($appointmentdate->appointment)) {
            return Response::json("APPOINTMENT FULL", 500);
        }

        $applicant = Applicant::where('sss', $request->inputSSS)->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME SSS", 500);
        }
        $applicant = Applicant::where('philhealth', $request->inputPHILHEALTH)->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME PHILHEALTH", 500);
        }
        $applicant = Applicant::where('pagibig', $request->inputPAGIBIG)->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME PAGIBIG", 500);
        }
        $applicant = Applicant::where('tin', $request->inputTIN)->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME TIN", 500);
        }
        $applicant = Applicant::where('license', $request->inputLicense)->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME LICENSE", 500);
        }

        $account = Account::create([
            'username' => $request->inputUsername,
            'password' => bcrypt($request->inputPassword),
            'accounttype' => 20,
        ]);

        $applicant = new Applicant;
        $applicant->account()->associate($account);
        $applicant->lastname = $request->inputLastname;
        $applicant->firstname = $request->inputFirstname;
        $applicant->middlename = $request->inputMiddlename;
        $applicant->suffix = $request->inputSuffix;
        $applicant->cityaddress = $request->inputCityAddress;
        $applicant->cityaddressprovince = $request->inputCityAddressProvince;
        $applicant->cityaddresscity = $request->inputCityAddressCity;
        $applicant->provincialaddress = $request->inputProvincialAddress;
        $applicant->provincialaddressprovince = $request->inputProvincialAddressProvince;
        $applicant->provincialaddresscity = $request->inputProvincialAddressCity;
        $applicant->latitude = $request->inputLatitude;
        $applicant->longitude = $request->inputLongitude;
        $applicant->gender = $request->inputGender;
        $applicant->picture = "default.png";
        $applicant->dateofbirth = $request->inputDateOfBirth;
        $applicant->placeofbirth = $request->inputPlaceOfBirth;
        $applicant->age = $request->inputAge;
        $applicant->civilstatus = $request->inputCivilStatus;
        $applicant->religion = $request->inputReligion;
        $applicant->bloodtype = $request->inputBloodType;
        $applicant->appcontactno = $request->inputAppContactNo;
        $applicant->workexp = $request->inputWorkExp;
        $applicant->height = $request->inputHeight;
        $applicant->weight = $request->inputWeight;
        $applicant->license = $request->inputLicense;
        $applicant->licenseexpiration = $request->inputLicenseExpiration;
        $applicant->sss = $request->inputSSS;       
        $applicant->philhealth = $request->inputPHILHEALTH;
        $applicant->pagibig = $request->inputPAGIBIG;
        $applicant->tin = $request->inputTIN;
        $applicant->hobby = $request->inputHobby;
        $applicant->skill = $request->inputSkill;
        $applicant->spousename = $request->inputSpouseName;
        $applicant->spousedateofbirth = $request->inputSpouseDateOfBirth;
        $applicant->spouseoccupation = $request->inputSpouseOccupation;
        $applicant->contactperson = $request->inputContactPerson;
        $applicant->contactno = $request->inputContactNo;
        $applicant->contacttelno = $request->inputContactTelNo;
        $applicant->status = 0;
        $applicant->save();

        if ($request->inputEBList != null) {
            foreach ($request->inputEBList as $inputEBList) {
                $educationbackground = new EducationBackground;
                $educationbackground->applicant()->associate($applicant);
                $educationbackground->graduatetype = $inputEBList['inputGraduateType'];
                $educationbackground->degree = $inputEBList['inputDegree'];
                $educationbackground->dategraduated = $inputEBList['inputDateGraduated'];
                $educationbackground->schoolgraduated = $inputEBList['inputSchoolGraduated'];
                $educationbackground->save();
            }
        }

        if ($request->inputERList != null) {
            foreach ($request->inputERList as $inputERList) {
                $employmentrecord = new EmploymentRecord;
                $employmentrecord->applicant()->associate($applicant);
                $employmentrecord->industrytype = $inputERList['inputIndustryType'];
                $employmentrecord->company = $inputERList['inputCompany'];
                $employmentrecord->duration = $inputERList['inputDuration'];
                $employmentrecord->reason = $inputERList['inputReason'];
                $employmentrecord->save();
            }
        }

        if ($request->inputTCList != null) {
            foreach ($request->inputTCList as $inputTCList) {
                $trainingcertificate = new TrainingCertificate;
                $trainingcertificate->applicant()->associate($applicant);
                $trainingcertificate->certificate = $inputTCList['inputCertificate'];
                $trainingcertificate->conductedby = $inputTCList['inputConductedBy'];
                $trainingcertificate->dateconducted = $inputTCList['inputDateConducted'];
                $trainingcertificate->save();
            }
        }

        $appointment = new Appointment;
        $appointment->applicant()->associate($applicant);
        $appointment->appointmentdate()->associate($appointmentdate);
        $appointment->save();

        $requirements = Requirement::get();
        foreach($requirements as $requirement) {
            $applicantrequirement = new ApplicantRequirement;
            $applicantrequirement->applicant()->associate($applicant);
            $applicantrequirement->requirement()->associate($requirement);
            $applicantrequirement->issubmitted = 0;
            $applicantrequirement->save();
        }

        if (Auth::attempt(['username' => $request->inputUsername, 'password' => $request->inputPassword])) {
            return Response::json($applicant);
        }
    }

    //sign out
    public function getSignOut() {
        Auth::logout();

        return redirect()
            ->route('signin')
            ->with('info', 'YOU HAVE SUCCESSFULLY LOGOUT');
    }
}
