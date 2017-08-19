<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Appointment;
use Amcor\Applicant;
use Amcor\ApplicantRequirement;
use Amcor\Requirement;
use Amcor\EducationBackground;
use Amcor\EmploymentRecord;
use Amcor\TrainingCertificate;
use Carbon\Carbon;
use Response;
use Image;

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
        $applicant->birthdate = $request->inputBirthdate;
        $applicant->birthplace = $request->inputBirthplace;
        $applicant->age = $request->inputAge;
        $applicant->civilstatus = $request->inputCivilStatus;
        $applicant->religion = $request->inputReligion;
        $applicant->bloodtype = $request->inputBloodType;
        $applicant->appcontactno = $request->inputAppContactNo;
        $applicant->height = $request->inputHeight;
        $applicant->weight = $request->inputWeight;
        $applicant->hobby = $request->inputHobby;
        $applicant->skill = $request->inputSkill;
        $applicant->save();

        return Response::json($applicant);
    }

    public function postAdminProfileImage(Request $request) {
        $applicant = Applicant::find($request->get('applicantid'));

        if ($request->hasFile('image')) {
            if (!($applicant->picture === "default.png")) {
                \File::delete('applicant/' . $applicant->picture);
            }

            $picture = $request->file('image');

            $filename = time() . $picture->getClientOriginalName();
            Image::make($picture)->save('applicant/' . $filename);

            $applicant->picture = $filename;
            $applicant->save();
        }
    }

    public function postAdminAccount(Request $request) {
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        $applicant = Applicant::find($request->inputApplicantID);
        $applicant->account->username = $request->inputUsername;
        $applicant->account->password = bcrypt($request->inputPassword);
        $applicant->account->save();

        return Response::json($applicant);
    }

    public function postAdminID(Request $request) {
        $applicant = Applicant::where([
                ['sss', $request->inputSSS],
                ['applicantid', '!=', $request->inputApplicantID],
            ])->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME SSS", 500);
        }
        $applicant = Applicant::where([
                ['philhealth', $request->inputPHILHEALTH],
                ['applicantid', '!=', $request->inputApplicantID],
            ])->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME PHILHEALTH", 500);
        }
        $applicant = Applicant::where([
                ['pagibig', $request->inputPAGIBIG],
                ['applicantid', '!=', $request->inputApplicantID],
            ])->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME PAGIBIG", 500);
        }
        $applicant = Applicant::where([
                ['tin', $request->inputTIN],
                ['applicantid', '!=', $request->inputApplicantID],
            ])->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME TIN", 500);
        }
        $applicant = Applicant::where([
                ['license', $request->inputLicense],
                ['applicantid', '!=', $request->inputApplicantID],
            ])->get();
        if (!($applicant->isEmpty())) {
            return Response::json("SAME LICENSE", 500);
        }

        $applicant = Applicant::find($request->inputApplicantID);
        $applicant->license = $request->inputLicense;
        $applicant->licenseexpiration = $request->inputLicenseExpiration;
        $applicant->sss = $request->inputSSS;       
        $applicant->philhealth = $request->inputPHILHEALTH;
        $applicant->pagibig = $request->inputPAGIBIG;
        $applicant->tin = $request->inputTIN;
        $applicant->spousename = $request->inputSpouseName;
        $applicant->spousebirthdate = $request->inputSpouseBirthdate;
        $applicant->spouseoccupation = $request->inputSpouseOccupation;
        $applicant->contactperson = $request->inputContactPerson;
        $applicant->contactno = $request->inputContactNo;
        $applicant->contacttelno = $request->inputContactTelNo;
        $applicant->save();

        return Response::json($applicant);
    }

    public function postBackgroundInfo(Request $request) {
        EducationBackground::where('applicantid', $request->inputApplicantID)->forceDelete();
        EmploymentRecord::where('applicantid', $request->inputApplicantID)->forceDelete();
        TrainingCertificate::where('applicantid', $request->inputApplicantID)->forceDelete();
        $applicant = Applicant::find($request->inputApplicantID);

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

        $applicant->workexp = $request->inputWorkExp;
        $applicant->save();

        return Response::json($applicant);
    }
}
