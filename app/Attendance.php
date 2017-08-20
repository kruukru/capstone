<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $table = 'attendancetbl';
    protected $primaryKey = 'attendanceid';
    protected $dates = ['date', 'deleted_at'];

    public function deploy() {
    	return $this->belongsTo('Amcor\Deploy', 'deployid');
    }

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
