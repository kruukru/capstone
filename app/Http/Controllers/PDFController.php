<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Contract;
use Amcor\Applicant;
use Amcor\Appointment;
use Amcor\ApplicantRequirement;
use Amcor\Score;
use Amcor\Attendance;
use Amcor\DeploymentSite;
use Amcor\Report;
use Amcor\Firearm;
use Amcor\Item;
use Amcor\IssuedItem;
use Amcor\FloatNumber;
use Amcor\Client;
use Carbon\Carbon;
use DateTime;
use PDF;
use Auth;

class PDFController extends Controller
{
    //admin report
    public function getAdminReport() {
        $deploymentsites = DeploymentSite::where('status', 5)->get();
        $applicants = Applicant::where('status', 10)->get();

        return view('admin.report.report', compact('deploymentsites', 'applicants'));
    }

    public function getAdminFirearmLicense(Request $request) {
        $deploymentsiteid = $request->input('firearmdeploymentsiteid');
        $startdate = $request->input('firearmstartdate');
        $enddate = $request->input('firearmenddate');
 
        if ($deploymentsiteid == "none") {
            if ($startdate == null && $enddate == null) {
                $firearms = Firearm::with('item')->orderBy('expiration')->get();
            } else {
                $firearms = Firearm::with('item')->whereBetween('expiration', array($startdate, $enddate))
                    ->orderBy('expiration')->get();
            }
        } else {
            if ($startdate == null && $enddate == null) {
                $firearms = Firearm::with('item')->whereHas('issuedfirearm.issueditem', function($query) use ($deploymentsiteid) {
                    $query->where('deploymentsiteid', $deploymentsiteid);
                })->orderBy('expiration')->get();
            } else {
                $firearms = Firearm::with('item')->whereBetween('expiration', array($startdate, $enddate))
                    ->whereHas('issuedfirearm.issueditem', function($query) use ($deploymentsiteid) {
                        $query->where('deploymentsiteid', $deploymentsiteid);
                    })->orderBy('expiration')->get();
                }
        }

        $pdf = PDF::loadView('admin.pdf.firearmlicense', compact('firearms'));
        return $pdf->stream();
    }

    public function getAdminSecurityLicense(Request $request) {
        $deploymentsiteid = $request->input('securitydeploymentsiteid');
        $startdate = $request->input('securitystartdate');
        $enddate = $request->input('securityenddate');
 
        if ($deploymentsiteid == "none") {
            if ($startdate == null && $enddate == null) {
                $applicants = Applicant::orderBy('licenseexpiration')->get();
            } else {
                $applicants = Applicant::whereBetween('licenseexpiration', array($startdate, $enddate))
                    ->orderBy('licenseexpiration')->get();
            }
        } else {
            if ($startdate == null && $enddate == null) {
                $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsiteid) {
                    $query->where('deploymentsiteid', $deploymentsiteid);
                })->orderBy('licenseexpiration')->get();
            } else {
                $applicants = Applicant::whereBetween('licenseexpiration', array($startdate, $enddate))
                    ->whereHas('qualificationcheck', function($query) use ($deploymentsiteid) {
                        $query->where('deploymentsiteid', $deploymentsiteid);
                    })->orderBy('licenseexpiration')->get();
            }
        }

        $pdf = PDF::loadView('admin.pdf.securitylicense', compact('applicants'));
        return $pdf->stream();
    }

    public function getAdminEquipment(Request $request) {
        $deploymentsiteid = $request->input('equipmentdeploymentsiteid');
        $deploymentsite = DeploymentSite::find($deploymentsiteid);

        if ($deploymentsiteid == "none") {
            $deploymentsiteout = "All";
            $items = Item::get();
        } else {
            $deploymentsiteout = $deploymentsite->sitename . ", " . $deploymentsite->location;
            $items = IssuedItem::where('deploymentsiteid', $deploymentsiteid)->get();
        }

        $pdf = PDF::loadView('admin.pdf.equipment', compact('items', 'deploymentsiteout'));
        return $pdf->stream();
    }

    public function getAdminDutyDetailOrder(Request $request) {
        $deploymentsiteid = $request->input('ddodeploymentsiteid');
        $applicantid = $request->input('ddosecurityguardid');
        $purpose = $request->input('ddopurpose');
        $startdate = Carbon::parse($request->input('ddostartdate'));
        $enddate = Carbon::parse($request->input('ddoenddate'));
        $floatnumber = new FloatNumber;
        $floatnumber->save();

        if ($deploymentsiteid == "none" && $applicantid == "none") {
            $applicants = Applicant::where('status', 10)->get();
        } else if ($deploymentsiteid == "none" && $applicantid != "none") {
            $applicants = Applicant::where('applicantid', $applicantid)->get();
        } else {
            $applicants = Applicant::whereHas('qualificationcheck', function($query) use ($deploymentsiteid) {
                $query->where('deploymentsiteid', $deploymentsiteid);
            })->get();
        }

        $pdf = PDF::loadView('admin.pdf.dutydetailorder', compact('applicants', 'purpose', 'startdate', 'enddate', 'floatnumber'));
        return $pdf->stream();
    }

    public function getAdminMonthlyDispositionReport(Request $request) {
        $deploymentsiteid = $request->input('mdrdeploymentsiteid');

        if ($deploymentsiteid == "none") {
            $contracts = Contract::get();
        } else {
            $contracts = Contract::whereHas('deploymentsite', function($query) use ($deploymentsiteid) {
                $query->where('deploymentsiteid', $deploymentsiteid);
            })->get();
        }

        $pdf = PDF::loadView('admin.pdf.monthlydispositionreport', compact('contracts'));
        $pdf->setpaper(array(0,0,612,936), 'landscape');
        return $pdf->stream();
    }

    //admin
    public function getAdminContractDocument($contractid) {
        $contract = Contract::with('client', 'deploymentsite')->find($contractid);

        if ($contract == null) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('admin.pdf.contract', compact('contract'));
        return $pdf->stream();
    }

    public function getAdminTestResultDocument($applicantid) {
        $applicant = Applicant::find($applicantid);
        $scores = Score::where([
            ['applicantid', $applicantid],
            ['item', '!=', 0],
        ])->get();

        if ($applicant == null || $scores->isEmpty()) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('admin.pdf.testresult', compact('applicant', 'scores'));
        return $pdf->stream();
    }

    public function getAdminReportCertificate(Request $request) {
        $applicants = Applicant::whereHas('personinvolve', function($query) use ($request) {
            $query->where('reportid', $request->input('certificatereportid'));
        })->get();
        $certificatedescription = $request->input('certificatedescription');

        $pdf = PDF::loadView('admin.pdf.certificate', compact('applicants', 'certificatedescription'));
        return $pdf->stream();
    }

    public function getAdminReportMemorandum(Request $request) {
        $applicants = Applicant::with('qualificationcheck.deploymentsite')->whereHas('personinvolve', function($query) use ($request) {
            $query->where('reportid', $request->input('memorandumreportid'));
        })->get();
        $subject = $request->input('subject');
        $memorandumbody = $request->input('memorandumbody');
        $floatnumber = new FloatNumber;
        $floatnumber->save();

        $pdf = PDF::loadView('admin.pdf.memorandum', compact('applicants', 'subject', 'memorandumbody', 'floatnumber'));
        return $pdf->stream();
    }

    //manager
    public function getManagerAttendanceDocument($deploymentsiteid) {
        $deploymentsite = DeploymentSite::find($deploymentsiteid);
        $attendances = Attendance::where([
            ['deploymentsiteid', $deploymentsiteid],
            ['date', Carbon::today()],
        ])->orderBy('status')->get();

        if ($deploymentsite == null) {
            return view('errors.404');
        }

        $pdf = PDF::loadView('manager.pdf.attendance', compact('attendances', 'deploymentsite'));
        return $pdf->stream();
    }

    //applicant
    public function getApplicantAppointmentVoucher() {
    	$applicant = Applicant::find(Auth::user()->applicant->applicantid);
    	$applicantrequirements = ApplicantRequirement::with('Requirement')
    		->where('applicantid', Auth::user()->applicant->applicantid)
    		->get();
    	$appointment = Appointment::with('AppointmentDate')
    		->where('applicantid', Auth::user()->applicant->applicantid)
    		->first();

	    $pdf = PDF::loadView('applicant.pdf.appointmentvoucher', compact('applicant', 'appointment', 'applicantrequirements'));
	    return $pdf->stream();
    }

    //client
    public function getClientAttendance(Request $request) {
        $deploymentsiteid = $request->input('deploymentsiteid');
        $securityguardid = $request->input('securityguardid');
        $startdate = Carbon::parse($request->input('attendancestartdate'));
        $enddate = Carbon::parse($request->input('attendanceenddate'));

        if ($securityguardid != "none") {
            $applicant = Applicant::find($securityguardid);
            if ($applicant == null) {
                return view('errors.404');
            }

            $attendances = Attendance::where('applicantid', $applicant->applicantid)
                ->whereDate('date', '>=', $startdate)
                ->whereDate('date', '<=', $enddate)->get();

            $pdf = PDF::loadView('client.pdf.attendance-individual', compact('applicant', 'startdate', 'enddate', 'attendances'));
            return $pdf->stream();
        } else {
            $deploymentsite = DeploymentSite::find($deploymentsiteid);
            if ($deploymentsite == null) {
                return view('errors.404');
            }

            if ($startdate->format('m') != $enddate->format('m')) {
                $enddate = $startdate->endOfMonth();
                $startdate = Carbon::parse($request->input('attendancestartdate'));
            }

            $applicants = Applicant::whereHas('attendance', function($query) use ($deploymentsite, $startdate, $enddate) {
                $query->where('deploymentsiteid', $deploymentsite->deploymentsiteid)
                    ->whereDate('date', '>=', $startdate)
                    ->whereDate('date', '<=', $enddate);
            })->get();

            $collection = collect();
            foreach ($applicants as $applicant) {
                $attendances = Attendance::where([
                    ['deploymentsiteid', $deploymentsite->deploymentsiteid],
                    ['applicantid', $applicant->applicantid]
                ])->whereDate('date', '>=', $startdate)->whereDate('date', '<=', $enddate)->get();

                $d1 = ""; $d2 = ""; $d3 = ""; $d4 = ""; $d5 = ""; $d6 = ""; $d7 = ""; $d8 = ""; $d9 = ""; $d10 = ""; $d11 = ""; $d12 = ""; $d13 = ""; $d14 = ""; $d15 = ""; $d16 = ""; $d17 = ""; $d18 = ""; $d19 = ""; $d20 = ""; $d21 = ""; $d22 = ""; $d23 = ""; $d24 = ""; $d25 = ""; $d26 = ""; $d27 = ""; $d28 = ""; $d29 = ""; $d30 = ""; $d31 = "";
                $present = 0; $late = 0; $absent = 0;
                foreach ($attendances as $attendance) {
                    if ($attendance->date->format('d') == 1) {
                        if ($attendance->status == 0) {
                            $d1 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d1 = "L"; $late++;
                        } else {
                            $d1 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 2) {
                        if ($attendance->status == 0) {
                            $d2 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d2 = "L"; $late++;
                        } else {
                            $d2 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 3) {
                        if ($attendance->status == 0) {
                            $d3 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d3 = "L"; $late++;
                        } else {
                            $d3 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 4) {
                        if ($attendance->status == 0) {
                            $d4 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d4 = "L"; $late++;
                        } else {
                            $d4 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 5) {
                        if ($attendance->status == 0) {
                            $d5 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d5 = "L"; $late++;
                        } else {
                            $d5 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 6) {
                        if ($attendance->status == 0) {
                            $d6 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d6 = "L"; $late++;
                        } else {
                            $d6 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 7) {
                        if ($attendance->status == 0) {
                            $d7 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d7 = "L"; $late++;
                        } else {
                            $d7 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 8) {
                        if ($attendance->status == 0) {
                            $d8 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d8 = "L"; $late++;
                        } else {
                            $d8 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 9) {
                        if ($attendance->status == 0) {
                            $d9 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d9 = "L"; $late++;
                        } else {
                            $d9 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 10) {
                        if ($attendance->status == 0) {
                            $d10 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d10 = "L"; $late++;
                        } else {
                            $d10 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 11) {
                        if ($attendance->status == 0) {
                            $d11 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d11 = "L"; $late++;
                        } else {
                            $d11 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 12) {
                        if ($attendance->status == 0) {
                            $d12 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d12 = "L"; $late++;
                        } else {
                            $d12 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 13) {
                        if ($attendance->status == 0) {
                            $d13 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d13 = "L"; $late++;
                        } else {
                            $d13 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 14) {
                        if ($attendance->status == 0) {
                            $d14 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d14 = "L"; $late++;
                        } else {
                            $d14 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 15) {
                        if ($attendance->status == 0) {
                            $d15 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d15 = "L"; $late++;
                        } else {
                            $d15 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 16) {
                        if ($attendance->status == 0) {
                            $d16 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d16 = "L"; $late++;
                        } else {
                            $d16 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 17) {
                        if ($attendance->status == 0) {
                            $d17 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d17 = "L"; $late++;
                        } else {
                            $d17 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 18) {
                        if ($attendance->status == 0) {
                            $d18 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d18 = "L"; $late++;
                        } else {
                            $d18 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 19) {
                        if ($attendance->status == 0) {
                            $d19 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d19 = "L"; $late++;
                        } else {
                            $d19 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 20) {
                        if ($attendance->status == 0) {
                            $d20 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d20 = "L"; $late++;
                        } else {
                            $d20 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 21) {
                        if ($attendance->status == 0) {
                            $d21 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d21 = "L"; $late++;
                        } else {
                            $d21 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 22) {
                        if ($attendance->status == 0) {
                            $d22 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d22 = "L"; $late++;
                        } else {
                            $d22 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 23) {
                        if ($attendance->status == 0) {
                            $d23 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d23 = "L"; $late++;
                        } else {
                            $d23 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 24) {
                        if ($attendance->status == 0) {
                            $d24 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d24 = "L"; $late++;
                        } else {
                            $d24 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 25) {
                        if ($attendance->status == 0) {
                            $d25 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d25 = "L"; $late++;
                        } else {
                            $d25 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 26) {
                        if ($attendance->status == 0) {
                            $d26 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d26 = "L"; $late++;
                        } else {
                            $d26 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 27) {
                        if ($attendance->status == 0) {
                            $d27 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d27 = "L"; $late++;
                        } else {
                            $d27 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 28) {
                        if ($attendance->status == 0) {
                            $d28 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d28 = "L"; $late++;
                        } else {
                            $d28 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 29) {
                        if ($attendance->status == 0) {
                            $d29 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d29 = "L"; $late++;
                        } else {
                            $d29 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 30) {
                        if ($attendance->status == 0) {
                            $d30 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d30 = "L"; $late++;
                        } else {
                            $d30 = "A"; $absent++;
                        }
                    } else if ($attendance->date->format('d') == 31) {
                        if ($attendance->status == 0) {
                            $d31 = "P"; $present++;
                        } else if ($attendance->status == 1) {
                            $d31 = "L"; $late++;
                        } else {
                            $d31 = "A"; $absent++;
                        }
                    }
                }

                $collection->push([
                    'name' => $applicant->firstname . " " . $applicant->middlename . " " . $applicant->lastname,
                    'd1' => $d1,
                    'd2' => $d2,
                    'd3' => $d3,
                    'd4' => $d4,
                    'd5' => $d5,
                    'd6' => $d6,
                    'd7' => $d7,
                    'd8' => $d8,
                    'd9' => $d9,
                    'd10' => $d10,
                    'd11' => $d11,
                    'd12' => $d12,
                    'd13' => $d13,
                    'd14' => $d14,
                    'd15' => $d15,
                    'd16' => $d16,
                    'd17' => $d17,
                    'd18' => $d18,
                    'd19' => $d19,
                    'd20' => $d20,
                    'd21' => $d21,
                    'd22' => $d22,
                    'd23' => $d23,
                    'd24' => $d24,
                    'd25' => $d25,
                    'd26' => $d26,
                    'd27' => $d27,
                    'd28' => $d28,
                    'd29' => $d29,
                    'd30' => $d30,
                    'd31' => $d31,
                    'present' => $present,
                    'late' => $late,
                    'absent' => $absent,
                ]);
            }

            $pdf = PDF::loadView('client.pdf.attendance-detachment', compact('collection', 'deploymentsite', 'startdate', 'enddate'));
            $pdf->setpaper(array(0,0,612,936), 'landscape');
            return $pdf->stream();
        }
    }
}
