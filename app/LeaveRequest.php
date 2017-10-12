<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use SoftDeletes;

    protected $table = 'leaverequesttbl';
    protected $primaryKey = 'leaverequestid';
    protected $dates = ['start', 'end', 'deleted_at'];

    public function relieverleave() {
    	return $this->hasMany('Amcor\RelieverLeave', 'leaverequestid');
    }

    public function request() {
        return $this->belongsTo('Amcor\Requestt', 'requestid');
    }

    public function applicant() {
        return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
