<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelieverAbsent extends Model
{
    use SoftDeletes;

    protected $table = 'relieverabsenttbl';
    protected $primaryKey = 'relieverabsentid';
    protected $dates = ['deleted_at'];

    public function reliever() {
        return $this->belongsTo('Amcor\Reliever', 'relieverid');
    }

    public function attendance() {
        return $this->belongsTo('Amcor\Attendance', 'attendanceid');
    }
}
