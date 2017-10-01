<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Holiday;
use Amcor\AppointmentSlot;
use Amcor\AppointmentDate;
use Amcor\Appointment;
use Amcor\Company;
use Amcor\Account;
use Amcor\Admin;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Response;
use Image;

class UtilityController extends Controller
{
    //appointment appointment appointment appointment appointment appointment appointment appointment appointment appointment 
    public function getAdminAppointment() {
    	$holidays = Holiday::get();
        $appointmentslot = AppointmentSlot::first();

    	return view('admin.utility.appointment', compact('holidays', 'appointmentslot'));
    }

    public function postAdminAppointment(Request $request) {
        $appointmentslot = AppointmentSlot::first();

        $appointmentslot->sunday = $request->inputSunday == "true" ? 1: 0;
        $appointmentslot->monday = $request->inputMonday == "true" ? 1: 0;
        $appointmentslot->tuesday = $request->inputTuesday == "true" ? 1: 0;
        $appointmentslot->wednesday = $request->inputWednesday == "true" ? 1: 0;
        $appointmentslot->thursday = $request->inputThursday == "true" ? 1: 0;
        $appointmentslot->friday = $request->inputFriday == "true" ? 1: 0;
        $appointmentslot->saturday = $request->inputSaturday == "true" ? 1: 0;
        $appointmentslot->slot = $request->inputSlot;
        $appointmentslot->noofday = $request->inputDay;
        $appointmentslot->save();

        $begin = new DateTime(Carbon::today());
        $end = new DateTime(Carbon::today()->addDays($appointmentslot->noofday));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $appointmentdate = AppointmentDate::where('date', $dt->format("Y-m-d"))->first();
            if ($appointmentdate == null) {
                $holiday = Holiday::whereMonth('date', $dt->format("m"))
                    ->whereDay('date', $dt->format("d"))->first();
                if ($holiday == null) {
                    $check = false;
                    if ($dt->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
                        $check = true;
                    } else if ($dt->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
                        $check = true;
                    }

                    if ($check) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    }
                } else if ($holiday->yearly == 1) {
                    $appointmentdate = new AppointmentDate;
                    $appointmentdate->holiday()->associate($holiday);
                    $appointmentdate->date = $dt->format("Y-m-d");
                    $appointmentdate->save();
                } else if ($holiday->yearly == 0) {
                    if ($holiday->date->format("Y") == $dt->format("Y")) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    } else {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    }
                }
            } else {
                $holiday = Holiday::whereMonth('date', $dt->format("m"))
                    ->whereDay('date', $dt->format("d"))->first();
                if ($holiday == null) {
                    $check = true;
                    if ($dt->format("D") == ($appointmentslot->sunday == 1? "Sun": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->monday == 1? "Mon": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->tuesday == 1? "Tue": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->wednesday == 1? "Wed": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->thursday == 1? "Thu": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->friday == 1? "Fri": "")) {
                        $check = false;
                    } else if ($dt->format("D") == ($appointmentslot->saturday == 1? "Sat": "")) {
                        $check = false;
                    }

                    if ($check) {
                        $appointmentdate->appointment()->delete();
                        $appointmentdate->delete();
                    }
                } else if ($holiday->yearly == 1) {
                    if ($appointmentdate == null) {
                        $appointmentdate = new AppointmentDate;
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->date = $dt->format("Y-m-d");
                        $appointmentdate->save();
                    } else {
                        $appointmentdate->holiday()->associate($holiday);
                        $appointmentdate->save();
                    }
                } else if ($holiday->yearly == 0) {
                    if ($holiday->date->format("Y") == $dt->format("Y")) {
                        if ($appointmentdate == null) {
                            $appointmentdate = new AppointmentDate;
                            $appointmentdate->holiday()->associate($holiday);
                            $appointmentdate->date = $dt->format("Y-m-d");
                            $appointmentdate->save();
                        } else {
                            $appointmentdate->holiday()->associate($holiday);
                            $appointmentdate->save();
                        }
                    }
                }
            }
        }

        Appointment::whereHas('appointmentdate', function($query) {
            $query->where('date', '<', Carbon::today());
        })->whereHas('applicant', function($query) {
            $query->where('status', 0);
        })->forceDelete();
        Appointment::whereHas('appointmentdate', function($query) use ($appointmentslot) {
            $query->where('date', '>=', Carbon::today()->addDays($appointmentslot->noofday));
        })->forceDelete();
        
        AppointmentDate::where('date', '<', Carbon::today())
            ->whereDoesntHave('appointment')->forceDelete();
        AppointmentDate::where('date', '>=', Carbon::today()->addDays($appointmentslot->noofday))->forceDelete();

        return Response::json($appointmentslot);
    }

    public function postAdminHolidayNew(Request $request) {
    	$holiday = Holiday::where('name', $request->inputHoliday)
            ->first();
        if ($holiday !== null) {
        	return Response::json("SAME NAME", 500);
        }
        $inputHolidayDate = Carbon::parse($request->inputHolidayDate);
        $holiday = Holiday::whereMonth('date', $inputHolidayDate->month)
        	->whereDay('date', $inputHolidayDate->day)
        	->first();
        if ($holiday !== null) {
        	return Response::json("SAME DATE", 500);
        }

        $request->inputHolidayYearly = $request->inputHolidayYearly === "true"? 1: 0;

        $holiday = new Holiday;
        $holiday->name = $request->inputHoliday;
        $holiday->date = $request->inputHolidayDate;
        $holiday->yearly = $request->inputHolidayYearly;
        $holiday->save();

        return Response::json($holiday);
    }

    public function postAdminHolidayUpdate(Request $request) {
        $holiday = Holiday::where([
                ['name', $request->inputHoliday],
                ['holidayid', '!=', $request->inputHolidayID],
            ])->first();
        if ($holiday !== null) {
            return Response::json("SAME NAME", 500);
        }
        $inputHolidayDate = Carbon::parse($request->inputHolidayDate);
        $holiday = Holiday::where('holidayid', '!=', $request->inputHolidayID)
            ->whereMonth('date', $inputHolidayDate->month)
            ->whereDay('date', $inputHolidayDate->day)
            ->first();
        if ($holiday !== null) {
            return Response::json("SAME DATE", 500);
        }

        $request->inputHolidayYearly = $request->inputHolidayYearly === "true"? 1: 0;

        $holiday = Holiday::find($request->inputHolidayID);
        $holiday->name = $request->inputHoliday;
        $holiday->date = $request->inputHolidayDate;
        $holiday->yearly = $request->inputHolidayYearly;
        $holiday->save();

        return Response::json($holiday);
    }

    public function postAdminHolidayRemove(Request $request) {
        $holiday = Holiday::find($request->inputHolidayID);
        $holiday->delete();

        return Response::json($holiday);
    }

    //company company company company company company company company company company company company company company company company 
    public function getAdminCompany() {
        return view('admin.utility.company');
    }

    public function postAdminCompany(Request $request) {
        $company = Company::first();

        $company->name = $request->inputName;
        $company->shortname = $request->inputShortName;
        $company->address = $request->inputAddress;
        $company->contactno = $request->inputContactNo;
        $company->save();

        return Response::json($company);
    }

    public function postAdminCompanyLogo(Request $request) {
        $company = Company::first();

        if ($request->hasFile('image')) {
            \File::delete('images/' . $company->logo);

            $picture = $request->file('image');

            $filename = time() . $picture->getClientOriginalName();
            Image::make($picture)->save('images/' . $filename);

            $company->logo = $filename;
            $company->save();
        }
    }

    //account account account account account account account account account account account account account account account account account 
    public function getAdminAccount() {
        $accounts = Account::where([
            ['accounttype', '>=', 0],
            ['accounttype', '<=', 3]
        ])->get();

        return view('admin.utility.account', compact('accounts'));
    }

    public function postAdminAccountNew(Request $request) {
        $account = Account::where('username', $request->inputUsername)->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        if ($request->inputPosition == "Executive") {
            $accounttype = 0;
        } else if ($request->inputPosition == "Admin") {
            $accounttype = 1;
        } else if ($request->inputPosition == "Operation") {
            $accounttype = 2;
        } else if ($request->inputPosition == "HR") {
            $accounttype = 3;
        }

        $account = Account::create([
            'username' => $request->inputUsername,
            'password' => bcrypt($request->inputPassword),
            'accounttype' => $accounttype
        ]);

        $admin = new Admin;
        $admin->account()->associate($account);
        $admin->lastname = $request->inputLastName;
        $admin->firstname = $request->inputFirstName;
        $admin->middlename = $request->inputMiddleName;
        $admin->position = $request->inputPosition;
        $admin->save();

        return Response::json($admin);
    }

    public function postAdminAccountUpdate(Request $request) {
        $account = Account::where([
            ['username', $request->inputUsername],
            ['accountid', '!=', $request->inputAccountID]
        ])->get();
        if (!($account->isEmpty())) {
            return Response::json("SAME USERNAME", 500);
        }

        if ($request->inputPosition == "Executive") {
            $accounttype = 0;
        } else if ($request->inputPosition == "Admin") {
            $accounttype = 1;
        } else if ($request->inputPosition == "Operation") {
            $accounttype = 2;
        } else if ($request->inputPosition == "HR") {
            $accounttype = 3;
        }

        $account = Account::find($request->inputAccountID);
        $account->username = $request->inputUsername;
        $account->password = bcrypt($request->inputPassword);
        $account->accounttype = $accounttype;
        $account->save();

        $admin = Admin::with('account')->where('accountid', $request->inputAccountID)->first();
        $admin->lastname = $request->inputLastName;
        $admin->firstname = $request->inputFirstName;
        $admin->middlename = $request->inputMiddleName;
        $admin->position = $request->inputPosition;
        $admin->save();

        return Response::json($admin);
    }

    public function postAdminAccountRemove(Request $request) {
        $admin = Admin::where('accountid', $request->inputAccountID)->first();
        if (count($admin->testassessment) || count($admin->interviewassessment) || count($admin->contract)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            Admin::whereHas('account', function($query) use ($request) {
                $query->where('accountid', $request->inputAccountID);
            })->forceDelete();
            Account::find($request->inputAccountID)->forceDelete();

            return Response::json(400);
        }
    }
}
