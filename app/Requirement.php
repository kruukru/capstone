<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
	use SoftDeletes;

    protected $table = 'requirementtbl';
    protected $primaryKey = 'requirementid';
    protected $dates = ['deleted_at'];

    public function applicantrequirement() {
    	return $this->hasMany('Amcor\ApplicantRequirement', 'requirementid');
    }
}
