<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use SoftDeletes;

    protected $table = 'managertbl';
    protected $primaryKey = 'managerid';
    protected $dates = ['deleted_at'];

    public function client() {
    	return $this->belongsTo('Amcor\Client', 'clientid');
    }

    public function account() {
    	return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function managersite() {
        return $this->hasMany('Amcor\ManagerSite', 'managerid');
    }
}
