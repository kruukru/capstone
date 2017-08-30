<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\Admin;
use Amcor\TestAssessment;
use Amcor\InterviewAssessment;
use Amcor\AssessmentTopic;
use Amcor\Requirement;
use Amcor\ApplicantRequirement;
use Carbon\Carbon;
use Response;
use DB;

class AssessController extends Controller
{
	//assess test
    public function getAdminAssessTest(Request $request) {
    	// $applicants = Applicant::where(function($query) {
     //        $query->where('status', 2)
     //            ->orWhere('status', 3)
     //            ->orWHere('status', 6)
     //            ->orWHere('status', 7);
     //    })->get();

        $applicants = Applicant::where('status', '>=', 2)->get();

        return view('admin.transaction.assesstest', compact('applicants'));
    }

    public function getAdminTestScore(Request $request) {
        $score = DB::table('scoretbl')
            ->join('testtbl', 'testtbl.testid', '=', 'scoretbl.testid')
            ->where('scoretbl.applicantid', $request->inputApplicantID)
            ->get();

        return Response::json($score);
    }

    public function getAdminEssayAnswer(Request $request) {
        $essayanswer = DB::table('essayanswertbl')
            ->join('testquestiontbl', 'testquestiontbl.testquestionid', '=', 'essayanswertbl.testquestionid')
            ->join('questiontbl', 'questiontbl.questionid', '=', 'testquestiontbl.questionid')
            ->where('essayanswertbl.applicantid', $request->inputApplicantID)
            ->get();

        return Response::json($essayanswer);
    }

    public function postAdminAssessTest(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        $admin = Admin::find($request->inputAdminID);

        if ($request->formData != NULL) {
            foreach($request->formData as $data) {
                $assessmenttopic = AssessmentTopic::where('name', $data['inputAssessmentTopic'])->first();
                $testassessment = new TestAssessment;
                $testassessment->applicant()->associate($applicant);
                $testassessment->admin()->associate($admin);
                $testassessment->assessmenttopic()->associate($assessmenttopic);
                $testassessment->message = $data['inputAssessment'];
                $testassessment->save();
            }
        }

        if ($applicant->status == 2) {
            $applicant->status = 3;
        } else {
            $applicant->status = 7;
        }
        $applicant->save();

        return Response::json($applicant);
    }


    //assess interview
    public function getAdminAssessInterview() {
        $applicants = Applicant::where(function($query) {
            $query->where('status', 3)
                ->orWHere('status', 7);
        })->get();

        return view('admin.transaction.assessinterview', compact('applicants'));
    }

    public function getAdminTestAssessment(Request $request) {
        $testassessment = TestAssessment::with('AssessmentTopic')
            ->where('applicantid', $request->inputApplicantID)
            ->get();

        return Response::json($testassessment);
    }

    public function postAdminAssessInterview(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        $admin = Admin::find($request->inputAdminID);

        if ($request->formData != NULL) {
            foreach($request->formData as $data) {
                $assessmenttopic = AssessmentTopic::where('name', $data['inputAssessmentTopic'])->first();
                
                $interviewassessment = new InterviewAssessment;
                $interviewassessment->applicant()->associate($applicant);
                $interviewassessment->admin()->associate($admin);
                $interviewassessment->assessmenttopic()->associate($assessmenttopic);
                $interviewassessment->message = $data['inputAssessment'];
                $interviewassessment->save();
            }
        }

        if ($applicant->status == 3) {
            $applicant->status = 4;
        } else {
            $applicant->status = 8;
        }
        $applicant->lastdeployed = Carbon::today();
        $applicant->save();

        return Response::json($applicant);
    }

    public function postAdminAssessInterviewFail(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);

        $applicant->score()->forceDelete();
        $applicant->questionanswer()->forceDelete();
        $applicant->essayanswer()->forceDelete();
        $applicant->testassessment()->forceDelete();
        $applicant->status = 125;
        $applicant->save();

        return Response::json($applicant);
    }
}
