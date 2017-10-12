<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloatNumber extends Model
{
    use SoftDeletes;

    protected $table = 'floatnumbertbl';
    protected $primaryKey = 'floatnumberid';
    protected $dates = ['deleted_at'];
}
