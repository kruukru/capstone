<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;
use Amcor\ExamPass;
use Amcor\EducationBackground;
use Amcor\EmploymentRecord;
use Amcor\TrainingCertificate;
use Amcor\IndustryType;
use Amcor\QuestionAnswer;
use Amcor\EssayAnswer;
use Amcor\TestQuestion;
use Amcor\Test;
use Amcor\Score;
use Amcor\Assessment;
use Amcor\Admin;
use Amcor\Requirement;
use Amcor\ApplicantRequirement;
use Amcor\SecurityLicense;
use Auth;
use DB;
use Response;
use Image;

class ApplicantController extends Controller
{
    public function postApplicantPictureSave(Request $request) {
        if ($request->hasFile('picture')) {
            if(!(Auth::user()->applicant->picture === "default.png")) {
                \File::delete('applicant/' . Auth::user()->applicant->picture);
            }

            $picture = $request->file('picture');

            $filename = time() . $picture->getClientOriginalName();
            Image::make($picture)->save('applicant/' . $filename);

            Auth::user()->applicant->picture = $filename;
            Auth::user()->applicant->save();
        }

        return redirect()->back()->with('info', 'YOUR PROFILE HAS BEEN UPDATED');
    }    
}
