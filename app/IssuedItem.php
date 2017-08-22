<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssuedItem extends Model
{
    use SoftDeletes;

    protected $table = 'issueditemtbl';
    protected $primaryKey = 'issueditemid';
    protected $dates = ['deleted_at'];

    public function deploymentsite() {
        return $this->belongsTo('Amcor\DeploymentSite', 'deploymentsiteid');
    }

    public function deploy() {
    	return $this->belongsTo('Amcor\Deploy', 'deployid');
    }

    public function item() {
    	return $this->belongsTo('Amcor\Item', 'itemid');
    }

    public function issuedfirearm() {
        return $this->hasMany('Amcor\IssuedFirearm', 'issueditemid');
    }
}
