<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientQualification extends Model
{
    use SoftDeletes;

    protected $table = 'clientqualificationtbl';
    protected $primaryKey = 'clientqualificationid';
    protected $dates = ['deleted_at'];

    public function contract() {
    	return $this->belongsTo('Amcor\Contract', 'contractid');
    }

    public function qualificationcheck() {
        return $this->hasMany('Amcor\QualificationCheck', 'clientqualificationid');
    }
}
