<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EssayAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'essayanswertbl';
    protected $primaryKey = 'essayanswerid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function testquestion() {
    	return $this->belongsTo('Amcor\TestQuestion', 'testquestionid');
    }
}
