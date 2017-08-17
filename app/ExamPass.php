<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamPass extends Model
{
    use SoftDeletes;

    protected $table = 'exampasstbl';
    protected $primaryKey = 'exampassid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }
}
