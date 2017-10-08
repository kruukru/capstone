<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReplaceApplicant extends Model
{
    use SoftDeletes;

    protected $table = 'replaceapplicanttbl';
    protected $primaryKey = 'replaceapplicantid';
    protected $dates = ['deleted_at'];

    public function qualificationcheck() {
    	return $this->belongsTo('Amcor\QualificationCheck', 'qualificationcheckid');
    }

    public function account() {
    	return $this->belongsTo('Amcor\Account', 'accountid');
    }
}
