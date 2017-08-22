<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeploymentSite extends Model
{
    use SoftDeletes;

    protected $table = 'deploymentsitetbl';
    protected $primaryKey = 'deploymentsiteid';
    protected $dates = ['deleted_at'];

    public function contract() {
    	return $this->belongsTo('Amcor\Contract', 'contractid');
    }

    public function clientqualification() {
        return $this->hasMany('Amcor\ClientQualification', 'deploymentsiteid');
    }

    public function deploy() {
        return $this->hasMany('Amcor\Deploy', 'deploymentsiteid');
    }

    public function qualificationcheck() {
        return $this->hasMany('Amcor\QualificationCheck', 'deploymentsiteid');
    }

    public function issueditem() {
        return $this->hasMany('Amcor\IssuedItem', 'deploymentsiteid');
    }

    public function managersite() {
        return $this->hasMany('Amcor\ManagerSite', 'deploymentsiteid');
    }

    public function attendance() {
        return $this->hasMany('Amcor\Attendance', 'deploymentsiteid');
    }
}
