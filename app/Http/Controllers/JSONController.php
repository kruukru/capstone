<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Requirement;
use Amcor\AreaType;
use Amcor\ItemType;
use Amcor\Item;
use Amcor\Violation;
use Amcor\Question;
use Amcor\Choice;
use Amcor\Test;
use Amcor\AppointmentSlot;
use Amcor\Applicant;
use Amcor\AssessmentTopic;
use Amcor\Commend;
use Amcor\Holiday;
use Amcor\ClientQualification;
use Amcor\Account;
use Amcor\EducationBackground;
use Amcor\EmploymentRecord;
use Amcor\TrainingCertificate;
use Response;

class JSONController extends Controller
{
	public function getItemTypeAll() {
		$itemtype = ItemType::get();

		return Response::json($itemtype);
	}

	public function getQuestionChoiceAll(Request $request) {
		$choice = Choice::where('questionid', $request->inputQuestionID)->get();

        return Response::json($choice);
	}

    public function getAreaTypeAll() {
        $areatype = AreaType::get();

        return Response::json($areatype);
    }

    public function getAssessmentTopicAll() {
        $assessmenttopic = AssessmentTopic::get();

        return Response::json($assessmenttopic);
    }



    public function getApplicantOne(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);

        return Response::json($applicant);
    }

	public function getTestOne(Request $request) {
		$test = Test::find($request->inputTestID);

		return Response::json($test);
	}

    public function getRequirementOne(Request $request) {
    	$requirement = Requirement::find($request->inputRequirementID);

        return Response::json($requirement);
    }

    public function getAreaTypeOne(Request $request) {
    	$areatype = AreaType::find($request->inputAreaTypeID);

        return Response::json($areatype);
    }

    public function getItemTypeOne(Request $request) {
    	$itemtype = ItemType::find($request->inputItemTypeID);

        return Response::json($itemtype);
    }

    public function getItemOne(Request $request) {
    	$item = Item::find($request->inputItemID);

        return Response::json($item);
    }

    public function getViolationOne(Request $request) {
    	$violation = Violation::find($request->inputViolationID);

        return Response::json($violation);
    }

    public function getMultipleChoiceOne(Request $request) {
    	$multiplechoice = Question::find($request->inputQuestionID);

    	return Response::json($multiplechoice);
    }

    public function getTrueOrFalseOne(Request $request) {
    	$trueorfalse = Question::find($request->inputQuestionID);

    	return Response::json($trueorfalse);
    }

    public function getIdentificationOne(Request $request) {
    	$identification = Question::find($request->inputQuestionID);

    	return Response::json($identification);
    }

    public function getEssayOne(Request $request) {
    	$essay = Question::find($request->inputQuestionID);

    	return Response::json($essay);
    }

    public function getAppointmentSlotOne(Request $request) {
        $appointmentslot = AppointmentSlot::find($request->inputAppointmentSlotID);

        return Response::json($appointmentslot);
    }

    public function getClientOne(Request $request) {
        $client = Client::find($request->inputClientID);

        return Response::json($client);
    }

    public function getAssessmentTopicOne(Request $request) {
        $assessmenttopic = AssessmentTopic::find($request->inputAssessmentTopicID);

        return Response::json($assessmenttopic);
    }

    public function getCommendOne(Request $request) {
        $commend = Commend::find($request->inputCommendID);

        return Response::json($commend);
    }

    public function getHolidayOne(Request $request) {
        $holiday = Holiday::find($request->inputHolidayID);

        return Response::json($holiday);
    }

    public function getClientQualificationOne(Request $request) {
        $clientqualification = ClientQualification::find($request->inputClientQualificationID);

        return Response::json($clientqualification);
    }



    public function getApplicantEducationBackground(Request $request) {
        $educationbackground = EducationBackground::where('applicantid', $request->inputApplicantID)->get();

        return Response::json($educationbackground);
    }

    public function getApplicantEmploymentRecord(Request $request) {
        $employmentrecord = EmploymentRecord::where('applicantid', $request->inputApplicantID)->get();

        return Response::json($employmentrecord);
    }

    public function getApplicantTrainingCertificate(Request $request) {
        $trainingcertificate = TrainingCertificate::where('applicantid', $request->inputApplicantID)->get();

        return Response::json($trainingcertificate);
    }



    public function getValidateUsername(Request $request) {
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        return Response::json($account);
    }    
}
