<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commend extends Model
{
    use SoftDeletes;

    protected $table = 'commendtbl';
    protected $primaryKey = 'commendid';
    protected $dates = ['deleted_at'];
}
