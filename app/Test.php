<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use SoftDeletes;

    protected $table = 'testtbl';
    protected $primaryKey = 'testid';
    protected $dates = ['deleted_at'];

    public function testquestion() {
        return $this->hasMany('Amcor\TestQuestion', 'testid');
    }

    public function score() {
        return $this->hasMany('Amcor\Score', 'testid');
    }
}
