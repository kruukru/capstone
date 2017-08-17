<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function getAdminReportEmployeePooling() {
    	return view('admin.report.employeepooling');
    }

    public function getAdminReportSupply() {
    	return view('admin.report.supply');
    }

    public function getAdminReportFirearmLicenseExpiration() {
    	return view('admin.report.firearmlicenseexpiration');
    }

    public function getAdminReportSecurityLicenseExpiration() {
    	return view('admin.report.securitylicenseexpiration');
    }

    public function getAdminReportWarrantyExpiration() {
    	return view('admin.report.warrantyexpiration');
    }
}
