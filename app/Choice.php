<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Choice extends Model
{
    use SoftDeletes;

    protected $table = 'choicetbl';
    protected $primaryKey = 'choiceid';
    protected $dates = ['deleted_at'];

    public function question() {
    	return $this->belongsTo('Amcor\Question', 'questionid');
    }
}
