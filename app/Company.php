<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companytbl';
    protected $primaryKey = 'companyid';
    protected $dates = ['deleted_at'];
}
