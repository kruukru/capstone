<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManagerSite extends Model
{
    use SoftDeletes;

    protected $table = 'managersitetbl';
    protected $primaryKey = 'managersiteid';
    protected $dates = ['deleted_at'];

    public function manager() {
    	return $this->belongsTo('Amcor\Manager', 'managerid');
    }

    public function deploymentsite() {
    	return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }
}
