<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Applicant;

class SecurityGuardController extends Controller
{
    public function getAdminSecurityGuard() {
    	$applicants = Applicant::get();

    	return view('admin.transaction.securityguard', compact('applicants'));
    }
}
