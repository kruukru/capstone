<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonInvolve extends Model
{
    use SoftDeletes;

    protected $table = 'personinvolvetbl';
    protected $primaryKey = 'personinvolveid';
    protected $dates = ['deleted_at'];

    public function report() {
    	return $this->belongsTo('Amcor\Report', 'reportid');
    }

    public function applicant() {
        return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
