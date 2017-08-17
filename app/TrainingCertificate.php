<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingCertificate extends Model
{
    use SoftDeletes;

    protected $table = 'trainingcertificatetbl';
    protected $primaryKey = 'trainingcertificateid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
