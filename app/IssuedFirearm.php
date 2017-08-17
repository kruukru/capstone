<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssuedFirearm extends Model
{
    use SoftDeletes;

    protected $table = 'issuedfirearmtbl';
    protected $primaryKey = 'issuedfirearmid';
    protected $dates = ['deleted_at'];

    public function issueditem() {
    	return $this->belongsTo('Amcor\IssuedItem', 'issueditemid');
    }

    public function firearm() {
    	return $this->belongsTo('Amcor\Firearm', 'firearmid');
    }
}
