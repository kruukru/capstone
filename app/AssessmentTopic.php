<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentTopic extends Model
{
    use SoftDeletes;

    protected $table = 'assessmenttopictbl';
    protected $primaryKey = 'assessmenttopicid';
    protected $dates = ['deleted_at'];

    public function testassessment() {
    	return $this->hasMany('Amcor\TestAssessment', 'assessmenttopicid');
    }

    public function interviewassessment() {
    	return $this->hasMany('Amcor\InterviewAssessment', 'assessmenttopicid');
    }
}
