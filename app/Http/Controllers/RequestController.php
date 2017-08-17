<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function getMyRequest() {
    	return view('client.myrequest');
    }

    public function getApproveRequest() {
    	return view('client.approverequest');
    }
}
