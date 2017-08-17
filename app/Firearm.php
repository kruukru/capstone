<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firearm extends Model
{
    use SoftDeletes;

    protected $table = 'firearmtbl';
    protected $primaryKey = 'firearmid';
    protected $dates = ['expiration', 'deleted_at'];

    public function item() {
    	return $this->belongsTo('Amcor\Item', 'itemid');
    }

    public function issuedfirearm() {
        return $this->hasMany('Amcor\IssuedFirearm', 'firearmid');
    }
}
