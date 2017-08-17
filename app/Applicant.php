<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    protected $table = 'applicanttbl';
    protected $primaryKey = 'applicantid';
    protected $dates = ['dateofbirth', 'licenseexpiration', 'spousedateofbirth', 'deleted_at'];

    public function score() {
        return $this->hasMany('Amcor\Score', 'applicantid');
    }

    public function account() {
        return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function educationbackground() {
        return $this->hasMany('Amcor\EducationBackGround', 'applicantid');
    }

    public function employmentrecord() {
        return $this->hasMany('Amcor\EmploymentRecord', 'applicantid');
    }

    public function trainingcertificate() {
        return $this->hasMany('Amcor\TrainingCertificate', 'applicantid');
    }

    public function questionanswer() {
        return $this->hasMany('Amcor\QuestionAnswer', 'applicantid');
    }

    public function essayanswer() {
        return $this->hasMany('Amcor\EssayAnswer', 'applicantid');
    }

    public function assessment() {
        return $this->hasOne('Amcor\Assessment', 'applicantid');
    }

    public function applicantrequirement() {
        return $this->hasMany('Amcor\ApplicantRequirement', 'applicantid');
    }

    public function qualificationcheck() {
        return $this->hasMany('Amcor\QualificationCheck', 'applicantid');
    }

    public function appointment() {
        return $this->hasOne('Amcor\Appointment', 'applicantid');
    }
}
