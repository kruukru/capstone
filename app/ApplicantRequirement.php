<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantRequirement extends Model
{
    use SoftDeletes;

    protected $table = 'applicantrequirementtbl';
    protected $primaryKey = 'applicantrequirementid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function requirement() {
    	return $this->belongsTo('Amcor\Requirement', 'requirementid');
    }
}
