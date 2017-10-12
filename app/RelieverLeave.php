<?php

namespace Amcor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelieverLeave extends Model
{
    use SoftDeletes;

    protected $table = 'relieverleavetbl';
    protected $primaryKey = 'relieverleaveid';
    protected $dates = ['deleted_at'];

    public function reliever() {
        return $this->belongsTo('Amcor\Reliever', 'relieverid');
    }

    public function leaverequest() {
        return $this->belongsTo('Amcor\LeaveRequest', 'leaverequestid');
    }
}
