<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
	use SoftDeletes;

    protected $table = 'admintbl';
    protected $primaryKey = 'adminid';
    protected $dates = ['deleted_at'];

    public function account() {
    	return $this->belongsTo('Amcor\Account', 'accountid');
    }

    public function assessment() {
        return $this->hasOne('Amcor\Assessment', 'adminid');
    }

    public function contract() {
        return $this->hasMany('Amcor\Contract', 'adminid');
    }
}
