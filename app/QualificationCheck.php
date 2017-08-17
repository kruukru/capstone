<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualificationCheck extends Model
{
    use SoftDeletes;

    protected $table = 'qualificationchecktbl';
    protected $primaryKey = 'qualificationcheckid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function deploy() {
        return $this->belongsTo('Amcor\Deploy', 'deployid');
    }
}
