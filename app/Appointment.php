<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $table = 'appointmenttbl';
    protected $primaryKey = 'appointmentid';
    protected $dates = ['deleted_at'];

    public function applicant() {
    	return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function appointmentdate() {
    	return $this->belongsTo('Amcor\AppointmentDate', 'appointmentdateid');
    }
}
