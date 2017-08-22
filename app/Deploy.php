<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deploy extends Model
{
    use SoftDeletes;

    protected $table = 'deploytbl';
    protected $primaryKey = 'deployid';
    protected $dates = ['expiration', 'deleted_at'];

    public function deploymentsite() {
    	return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }

    public function request() {
        return $this->belongsTo('Amcor\Request', 'requestid');
    }

    public function issueditem() {
    	return $this->hasMany('Amcor\IssuedItem', 'deployid');
    }

    public function qualificationcheck() {
        return $this->hasMany('Amcor\QualificationCheck', 'deployid');
    }
}
