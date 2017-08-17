<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationBackground extends Model
{
    use SoftDeletes;

    protected $table = 'educationbackgroundtbl';
    protected $primaryKey = 'educationbackgroundid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
