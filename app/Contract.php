<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $table = 'contracttbl';
    protected $primaryKey = 'contractid';
    protected $dates = ['startdate', 'expiration', 'deleted_at'];

    public function clientqualification() {
        return $this->hasMany('Amcor\ClientQualification', 'contractid');
    }

    public function deploymentsite() {
        return $this->hasOne('Amcor\DeploymentSite', 'contractid');
    }

    public function client() {
    	return $this->belongsTo('Amcor\Client', 'clientid');
    }

    public function admin() {
    	return $this->belongsTo('Amcor\Admin', 'adminid');
    }

    public function areatype() {
    	return $this->belongsTo('Amcor\AreaType', 'areatypeid');
    }
}
