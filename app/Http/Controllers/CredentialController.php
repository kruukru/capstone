<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Appointment;
use Amcor\Applicant;
use Amcor\ApplicantRequirement;
use Amcor\Requirement;
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
        $applicant->dateofbirth = $request->inputDateOfBirth;
        $applicant->placeofbirth = $request->inputPlaceOfBirth;
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
        $applicant = Applicant::find($request->inputApplicantID);
        $applicant->account->username = $request->inputUsername;
        $applicant->account->password = bcrypt($request->inputPassword);
        $applicant->account->save();

        return Response::json($applicant);
    }
}
