<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'testquestiontbl';
    protected $primaryKey = 'testquestionid';
    protected $dates = ['deleted_at'];

    public function test() {
    	return $this->belongsTo('Amcor\Test', 'testid');
    }

    public function question() {
    	return $this->belongsTo('Amcor\Question', 'questionid');
    }

    public function questionanswer() {
        return $this->hasMany('Amcor\QuestionAnswer', 'testquestionid');
    }

    public function essayanswer() {
        return $this->hasMany('Amcor\EssayAnswer', 'testquestionid');
    }
}
