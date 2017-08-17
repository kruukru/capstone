<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentDate extends Model
{
    use SoftDeletes;

    protected $table = 'appointmentdatetbl';
    protected $primaryKey = 'appointmentdateid';
    protected $dates = ['date', 'deleted_at'];

    public function holiday() {
    	return $this->belongsTo('Amcor\Holiday', 'holidayid');
    }

    public function appointment() {
    	return $this->hasMany('Amcor\Appointment', 'appointmentdateid');
    }
}
