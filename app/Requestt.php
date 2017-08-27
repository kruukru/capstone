<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requestt extends Model
{
    use SoftDeletes;

    protected $table = 'requesttbl';
    protected $primaryKey = 'requestid';
    protected $dates = ['datecreated', 'deleted_at'];

    public function clientqualification() {
    	return $this->hasMany('Amcor\ClientQualification', 'requestid');
    }

    public function deploy() {
    	return $this->hasMany('Amcor\Deploy', 'requestid');
    }

    public function requestitem() {
        return $this->hasMany('Amcor\RequestItem', 'requestid');
    }

    public function account() {
        return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function deploymentsite() {
        return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }
}
