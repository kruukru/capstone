<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $table = 'clienttbl';
    protected $primaryKey = 'clientid';
    protected $dates = ['deleted_at'];
    
    public function contract() {
        return $this->hasMany('Amcor\Contract', 'clientid');
    }

    public function account() {
    	return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function manager() {
        return $this->belongsTo('Amcor\Manager', 'clientid');
    }
}
