<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Account extends Model implements AuthenticatableContract
{
	use Authenticatable;
    use SoftDeletes;
	
    protected $table = 'accounttbl';
    protected $primaryKey = 'accountid';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'username', 
        'password',
        'accounttype',
    ];

    protected $hidden = [
    	'password',
        'remember_token',
    ];

    public function admin() {
    	return $this->hasOne('Amcor\Admin', 'accountid');
    }

    public function applicant() {
        return $this->hasOne('Amcor\Applicant', 'accountid');
    }

    public function client() {
        return $this->hasOne('Amcor\Client', 'accountid');
    }

    public function manager() {
        return $this->hasOne('Amcor\Manager', 'accountid');
    }
}
