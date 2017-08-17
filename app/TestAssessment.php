<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestAssessment extends Model
{
    use SoftDeletes;

    protected $table = 'testassessmenttbl';
    protected $primaryKey = 'testassessmentid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function admin() {
    	return $this->belongsTo('Amcor\Admin', 'adminid');
    }

    public function assessmenttopic() {
    	return $this->belongsTo('Amcor\AssessmentTopic', 'assessmenttopicid');
    }
}
