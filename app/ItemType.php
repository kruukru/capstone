<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemType extends Model
{
	use SoftDeletes;

    protected $table = 'itemtypetbl';
    protected $primaryKey = 'itemtypeid';
    protected $dates = ['deleted_at'];

    public function item() {
    	return $this->hasMany('Amcor\Item', 'itemtypeid');
    }
}
