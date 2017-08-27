<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientQualification extends Model
{
    use SoftDeletes;

    protected $table = 'clientqualificationtbl';
    protected $primaryKey = 'clientqualificationid';
    protected $dates = ['deleted_at'];

    public function deploymentsite() {
    	return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }

    public function request() {
        return $this->belongsTo('Amcor\Requestt', 'requestid');
    }

    public function qualificationcheck() {
        return $this->hasMany('Amcor\QualificationCheck', 'clientqualificationid');
    }
}
