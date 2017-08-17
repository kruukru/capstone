<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $table = 'scoretbl';
    protected $primaryKey = 'scoreid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function test() {
    	return $this->belongsTo('Amcor\Test', 'testid');
    }
}
