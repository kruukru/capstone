<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'itemtbl';
    protected $primaryKey = 'itemid';
    protected $dates = ['deleted_at'];

    public function itemtype() {
    	return $this->belongsTo('Amcor\ItemType', 'itemtypeid');
    }

    public function firearm() {
    	return $this->hasMany('Amcor\Firearm', 'itemid');
    }

    public function issueditem() {
        return $this->hasMany('Amcor\IssuedItem', 'itemid');
    }

    public function requestitem() {
        return $this->hasMany('Amcor\RequestItem', 'itemid');
    }
}
