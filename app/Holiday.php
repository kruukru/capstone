<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use SoftDeletes;

    protected $table = 'holidaytbl';
    protected $primaryKey = 'holidayid';
    protected $dates = ['date', 'deleted_at'];
}
