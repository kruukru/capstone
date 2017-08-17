<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Violation extends Model
{
	use SoftDeletes;

    protected $table = 'violationtbl';
    protected $primaryKey = 'violationid';
    protected $dates = ['deleted_at'];
}
