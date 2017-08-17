<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaType extends Model
{
    use SoftDeletes;

    protected $table = 'areatypetbl';
    protected $primaryKey = 'areatypeid';
    protected $dates = ['deleted_at'];

    public function contract() {
    	return $this->hasMany('Amcor\Contract', 'areatypeid');
    }
}
