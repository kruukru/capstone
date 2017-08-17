<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentSlot extends Model
{
    use SoftDeletes;

    protected $table = 'appointmentslottbl';
    protected $primaryKey = 'appointmentslotid';
    protected $dates = ['deleted_at'];

    public function appointment() {
    	return $this->hasMany('Amcor\Appointment', 'appointmentslotid');
    }
}
