<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reliever extends Model
{
    use SoftDeletes;

    protected $table = 'relievertbl';
    protected $primaryKey = 'relieverid';
    protected $dates = ['date', 'deleted_at'];

    public function relieverabsent() {
    	return $this->hasMany('Amcor\RelieverAbsent', 'relieverid');
    }

    public function relieverleave() {
        return $this->hasMany('Amcor\RelieverLeave', 'relieverid');
    }

    public function applicant() {
        return $this->belongsTo('Amcor\Applicant', 'applicantid');
    }

    public function deploymentsite() {
        return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }
}
