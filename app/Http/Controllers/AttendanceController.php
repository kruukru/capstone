<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function getAttendance() {
    	return view ('client.attendance');
    }
}
