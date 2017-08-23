<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestItem extends Model
{
    use SoftDeletes;

    protected $table = 'requestitemtbl';
    protected $primaryKey = 'requestitemid';
    protected $dates = ['deleted_at'];

    public function request() {
        return $this->belongsTo('Amcor\Requestt', 'requestid');
    }

    public function item() {
        return $this->belongsTo('Amcor\Item', 'itemid');
    }
}
