<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionanswertbl';
    protected $primaryKey = 'questionanswerid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function testquestion() {
    	return $this->belongsTo('Amcor\TestQuestion', 'testquestionid');
    }
}
