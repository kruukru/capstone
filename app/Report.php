<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $table = 'reporttbl';
    protected $primaryKey = 'reportid';
    protected $dates = ['date', 'deleted_at'];

    public function account() {
    	return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function commend() {
    	return $this->belongsTo('Amcor\Commend', 'commendid');
    }

    public function violation() {
    	return $this->belongsTo('Amcor\Violation', 'violationid');
    }

    public function personinvolve() {
        return $this->hasMany('Amcor\PersonInvolve', 'reportid');
    }
}
