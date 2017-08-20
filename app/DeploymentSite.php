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

    public function deploy() {
        return $this->hasMany('Amcor\Deploy', 'deploymentsiteid');
    }

    public function managersite() {
        return $this->hasMany('Amcor\ManagerSite', 'deploymentsiteid');
    }
}
