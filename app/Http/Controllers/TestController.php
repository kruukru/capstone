<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Account;
use Amcor\Test;
use Amcor\TestQuestion;
use Amcor\Question;
use Amcor\ExamPass;
use Amcor\Applicant;
use Amcor\QuestionAnswer;
use Amcor\EssayAnswer;
use Amcor\Choice;
use Amcor\Score;
use Amcor\Appointment;
use Amcor\AppointmentSlot;
use Carbon\Carbon;
use Response;
use Hash;

class TestController extends Controller
{
    public function getAdminTestLogin() {
        return view('admin.transaction.testlogin');
    }

    public function postAdminTestLogin(Request $request) {
        $account = Account::where([
            ['username', $request->inputUsername],
            ['accounttype', 20],
        ])->first();

        if ($account == NULL) {
            return Response::json("INVALID USERNAME/PASSWORD", 500);
        } else {
            if (Hash::check($request->inputPassword, $account->password)) {
                $applicant = Applicant::where('accountid', $account->accountid)->first();
                if ($applicant->status == 1 || $applicant->status == 5) {
                    $appointment = Appointment::where('applicantid', $applicant->applicantid)->first();
                    if ($appointment == NULL) {
                        return Response::json("INVALID USERNAME/PASSWORD", 500);
                    } else if ($appointment->appointmentdate->date->format('Y-m-d') == Carbon::today()->format('Y-m-d')) {
                        return Response::json($applicant);
                    } else {
                        return Response::json("INVALID DATE", 500);
                    }
                }
            }

            return Response::json("INVALID USERNAME/PASSWORD", 500);
        }
    }

    public function getAdminTest() {
        return view('admin.transaction.test');
    }

    public function getAdminCheckTest() {
        $tests = Test::get();

        //validation for test
        if ($tests->isEmpty()) {
            return Response::json("NO TEST", 500);
        }

        //validation for question
        $check = false;
        foreach ($tests as $test) {
            if($test->testquestion->isEmpty()) {
                $check = true;
            }
        }
        if ($check) {
            return Response::json("NO QUESTION", 500);
        }

        return Response::json($tests);
    }

    public function getAdminTestQuestion(Request $request) {
        $testquestion = TestQuestion::where('testid', $request->inputTestID)
            ->take($request->inputMaxQuestion)
            ->inRandomOrder()
            ->get();

        return Response::json($testquestion);
    }
    
    public function getAdminQuestion(Request $request) {
        $question = Question::with('Choice')
        	->with('TestQuestion')
        	->where('questionid', $request->inputQuestionID)->get();

        return Response::json($question);
    }

    public function postAdminTestQuestionAnswer(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);

        foreach($request->formData as $data) {
            $testquestion = TestQuestion::find($data['inputTestQuestionID']);
            $question = Question::find($testquestion->questionid);

            if (count($question->choice)) {
                $questionanswer = new QuestionAnswer;
                $check = 1;

                $choice = Choice::where([
                        ['answer', $data['inputAnswer']],
                        ['questionid', $question->questionid],
                        ['iscorrect', 1],
                    ])->get();

                if ($choice->isEmpty()) {
                    $check = 0;
                }

                $questionanswer->applicant()->associate($applicant);
                $questionanswer->testquestion()->associate($testquestion);
                $questionanswer->answer = $data['inputAnswer'];
                $questionanswer->iscorrect = $check;
                $questionanswer->save();
            } else {
                $essayanswer = new EssayAnswer;
                $essayanswer->applicant()->associate($applicant);
                $essayanswer->testquestion()->associate($testquestion);
                $essayanswer->answer = $data['inputAnswer'];
                $essayanswer->save();
            }
        }

        return Response::json($applicant);
    }

    public function postAdminApplicantExamStatus(Request $request) {
        $applicant = Applicant::find($request->inputApplicantID);
        $tests = Test::get();

        foreach($tests as $test) {
            $testquestion = TestQuestion::where('testid', $test->testid)
                ->whereHas('questionanswer', function($query) use ($request) {
                    $query->where([
                        ['iscorrect', 1],
                        ['applicantid', $request->inputApplicantID],
                    ]);
                })->get();

            $testquestionitem = TestQuestion::where('testid', $test->testid)
                ->whereHas('question', function($query) {
                    $query->where('type', '!=', 3);
                })->get();

            $score = new Score;
            $score->applicant()->associate($applicant);
            $score->test()->associate($test);
            $score->score = count($testquestion);
            $score->item = count($testquestionitem);
            $score->save();
        }

    	if ($applicant->status == 1) {
            $applicant->status = 2;
        } else {
            $applicant->status = 6;
        }
        $applicant->save();

    	return Response::json($applicant);
    }


    
}
