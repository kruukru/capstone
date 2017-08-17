<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $table = 'questiontbl';
    protected $primaryKey = 'questionid';
    protected $dates = ['deleted_at'];

    public function choice() {
    	return $this->hasMany('Amcor\Choice', 'questionid');
    }

    public function testquestion() {
    	return $this->hasMany('Amcor\TestQuestion', 'questionid');
    }
}
