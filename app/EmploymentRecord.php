<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmploymentRecord extends Model
{
    use SoftDeletes;

    protected $table = 'employmentrecordtbl';
    protected $primaryKey = 'employmentrecordid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function industrytype() {
    	return $this->belongsTo('Amcor\IndustryType', 'industrytypeid');
    }
}
