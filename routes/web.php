<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//landing page
Route::name('home')->get('/', 'HomeController@index');

//sign out
Route::name('signout')->get('/signout', 'AccountController@getSignOut');

//json controller
Route::get('/json/industrytype/one', 'JSONController@getIndustryTypeOne');
Route::get('/json/requirement/one', 'JSONController@getRequirementOne');
Route::get('/json/areatype/one', 'JSONController@getAreaTypeOne');
Route::get('/json/itemtype/one', 'JSONController@getItemTypeOne');
Route::get('/json/item/one', 'JSONController@getItemOne');
Route::get('/json/violation/one', 'JSONController@getViolationOne');
Route::get('/json/multiplechoice/one', 'JSONController@getMultipleChoiceOne');
Route::get('/json/trueorfalse/one', 'JSONController@getTrueOrFalseOne');
Route::get('/json/identification/one', 'JSONController@getIdentificationOne');
Route::get('/json/essay/one', 'JSONController@getEssayOne');
Route::get('/json/test/one', 'JSONController@getTestOne');
Route::get('/json/appointmentslot/one', 'JSONController@getAppointmentSlotOne');
Route::get('/json/applicant/one', 'JSONController@getApplicantOne');
Route::get('/json/client/one', 'JSONController@getClientOne');
Route::get('/json/assessmenttopic/one', 'JSONController@getAssessmentTopicOne');
Route::get('/json/commend/one', 'JSONController@getCommendOne');
Route::get('/json/holiday/one', 'JSONController@getHolidayOne');
Route::get('/json/clientqualification/one', 'JSONController@getClientQualificationOne');
Route::get('/json/manager/one', 'JSONController@getManagerOne');

Route::get('/json/itemtype/all', 'JSONController@getItemTypeAll');
Route::get('/json/questionchoice/all', 'JSONController@getQuestionChoiceAll');
Route::get('/json/industrytype/all', 'JSONController@getIndustryTypeAll');
Route::get('/json/areatype/all', 'JSONController@getAreaTypeAll');
Route::get('/json/assessmenttopic/all', 'JSONController@getAssessmentTopicAll');

Route::get('/json/applicant/educationbackground', 'JSONController@getApplicantEducationBackground');
Route::get('/json/applicant/employmentrecord', 'JSONController@getApplicantEmploymentRecord');
Route::get('/json/applicant/trainingcertificate', 'JSONController@getApplicantTrainingCertificate');

Route::get('/json/validate-username', 'JSONController@getValidateUsername');

Route::group(['middleware' => ['guest']], function() {
	//sign in
	Route::name('signin')->get('/signin', 'AccountController@getSignIn');
	Route::post('/signin', 'AccountController@postSignIn');

	//sign up
	Route::name('signup')->get('/signup', 'AccountController@getSignUp');
	Route::get('/signup/appointmentdate', 'AppointmentController@getSignUpAppointmentDate');
	Route::post('/signup/appointment/set', 'AppointmentController@postSignUpAppointmentSet');
	Route::post('/signup', 'AccountController@postSignUp');
});

Route::group(['middleware' => ['auth']], function() {
	//admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
	Route::group(['middleware' => 'Amcor\Http\Middleware\AdminMiddleware'], function() {
		//transaction transaction transaction transaction transaction transaction transaction transaction transaction transaction transaction
		//submit credential
		Route::name('admin-transaction-submitcredential')->get('/admin/transaction/submitcredential', 'CredentialController@getAdminSubmitCredential');
		Route::get('/admin/transaction/applicantrequirement', 'CredentialController@getAdminApplicantRequirement');
		Route::post('/admin/transaction/requirement/pass', 'CredentialController@postAdminRequirementPass');
		Route::post('/admin/transaction/requirement/remove', 'CredentialController@postAdminRequirementRemove');
		Route::post('/admin/transaction/requirement/assess', 'CredentialController@postAdminRequirementAssess');

		Route::post('/admin/transaction/applicantinfo/personalinfo', 'CredentialController@postAdminPersonalInfo');
		Route::post('/admin/transaction/applicantinfo/profileimage', 'CredentialController@postAdminProfileImage');
		Route::post('/admin/transaction/applicantinfo/account', 'CredentialController@postAdminAccount');
		Route::post('/admin/transaction/applicantinfo/id', 'CredentialController@postAdminID');
		Route::post('/admin/transaction/applicantinfo/backgroundinfo', 'CredentialController@postBackgroundInfo');

		//test login
		Route::name('admin-transaction-testlogin')->get('/admin/transaction/testlogin', 'TestController@getAdminTestLogin');
		Route::post('/admin/transaction/testlogin', 'TestController@postAdminTestLogin');
		Route::get('/admin/transaction/test', 'TestController@getAdminTest');

		//applicant test
		Route::get('/admin/transaction/test-check', 'TestController@getAdminTestCheck');
		Route::get('/admin/transaction/testquestion', 'TestController@getAdminTestQuestion');
		Route::get('/admin/transaction/question', 'TestController@getAdminQuestion');
		Route::post('/admin/transaction/testquestionanswer', 'TestController@postAdminTestQuestionAnswer');
		Route::post('/admin/transaction/applicantexamstatus', 'TestController@postAdminApplicantExamStatus');

		//assess test
		Route::name('admin-transaction-assesstest')->get('/admin/transaction/assesstest', 'AssessController@getAdminAssessTest');
		Route::get('/admin/transaction/testscore', 'AssessController@getAdminTestScore');
		Route::get('/admin/transaction/essayanswer', 'AssessController@getAdminEssayAnswer');
		Route::post('/admin/transaction/assessmenttest', 'AssessController@postAdminAssessmentTest');

		//assess interview
		Route::name('admin-transaction-assessinterview')->get('/admin/transaction/assessinterview', 'AssessController@getAdminAssessInterview');
		Route::get('/admin/transaction/testassessment', 'AssessController@getAdminTestAssessment');
		Route::post('/admin/transaction/assessmentinterview', 'AssessController@postAdminAssessmentInterview');
		Route::post('/admin/transaction/assessmentfail', 'AssessController@postAdminAssessmentFail');

		//security guard
		Route::name('admin-transaction-securityguard')->get('/admin/transaction/securityguard', 'SecurityGuardController@getAdminSecurityGuard');

		//contract
		Route::name('admin-transaction-contract')->get('/admin/transaction/contract', 'ContractController@getAdminContract');
		Route::post('/admin/transaction/contract/renew', 'ContractController@postAdminContractRenew');
		Route::name('admin-contract-document')->get('/admin/contract/document/{contractid}', 'PDFController@getAdminContractDocument');

		//client
		Route::name('admin-transaction-client')->get('/admin/transaction/client', 'ClientController@getAdminClient');
		Route::post('/admin/transaction/client/new', 'ClientController@postAdminClientNew');
		Route::post('/admin/transaction/client/contract/new', 'ClientController@postAdminClientContractNew');

		//inventory
		Route::name('admin-transaction-inventory')->get('/admin/transaction/inventory', 'InventoryController@getAdminInventory');
		Route::get('/admin/transaction/inventory/firearm-validate', 'InventoryController@getValidateFirearm');
		Route::post('/admin/transaction/inventory/additem', 'InventoryController@postAdminInventoryAddItem');
		Route::post('/admin/transaction/inventory/addfirearm', 'InventoryController@postAdminInventoryAddFirearm');

		//deploy security guard
		Route::name('admin-transaction-deploysecurityguard')->get('/admin/transaction/deploysecurityguard', 'DeployController@getAdminDeploySecurityGuard');
		Route::get('/admin/transaction/clientqualification/get', 'DeployController@getClientQualification');
		Route::get('/admin/transaction/securityguard/percent', 'DeployController@getSecurityGuardPercent');
		Route::post('/admin/transaction/securityguard/add', 'DeployController@postSecurityGuardAdd');

		//deploy item
		Route::name('admin-transaction-deployitem')->get('/admin/transaction/deployitem', 'DeployController@getAdminDeployItem');
		Route::post('/admin/transaction/deployitem', 'DeployController@postAdminDeployItem');
		Route::get('/admin/transaction/deployitem/firearm', 'DeployController@getAdminFirearm');
		Route::get('/admin/transaction/deployitem/sg/inventory', 'DeployController@getAdminSGInventory');

		//request
		Route::name('admin-transaction-request')->get('/admin/transaction/request', 'RequestController@getAdminRequest');
		Route::post('/admin/transaction/request/decline', 'RequestController@postAdminDecline');

		Route::get('/admin/transaction/request/item/inventory', 'RequestController@getAdminItemInventory');
		Route::get('/admin/transaction/request/firearm', 'RequestController@getAdminFirearm');
		Route::post('/admin/transaction/request/item', 'RequestController@postAdminRequestItem');

		Route::get('/admin/transaction/request/clientqualification', 'RequestController@getAdminClientQualification');
		Route::post('/admin/transaction/request/clientqualification', 'RequestController@postAdminClientQualification');
		Route::get('/admin/transaction/request/securityguard/percent', 'RequestController@getAdminSecurityGuardPercent');

		//maintenance maintenance maintenance maintenance maintenance maintenance maintenance maintenance maintenance maintenance maintenance
		//assessment topic
		Route::name('admin-maintenance-assessmenttopic')->get('/admin/maintenance/assessmenttopic', 'MaintenanceController@getAdminAssessmentTopic');
		Route::post('/admin/maintenance/assessmenttopic/new', 'MaintenanceController@postAdminAssessmentTopicNew');
		Route::post('/admin/maintenance/assessmenttopic/update', 'MaintenanceController@postAdminAssessmentTopicUpdate');
		Route::post('/admin/maintenance/assessmenttopic/remove', 'MaintenanceController@postAdminAssessmentTopicRemove');

		//area type
		Route::name('admin-maintenance-areatype')->get('/admin/maintenance/areatype', 'MaintenanceController@getAdminAreaType');
		Route::post('/admin/maintenance/areatype/new', 'MaintenanceController@postAdminAreaTypeNew');
		Route::post('/admin/maintenance/areatype/update', 'MaintenanceController@postAdminAreaTypeUpdate');
		Route::post('/admin/maintenance/areatype/remove', 'MaintenanceController@postAdminAreaTypeRemove');

		//item type
		Route::name('admin-maintenance-itemtype')->get('/admin/maintenance/itemtype', 'MaintenanceController@getAdminItemType');
		Route::post('/admin/maintenance/itemtype/new', 'MaintenanceController@postAdminItemTypeNew');
		Route::post('/admin/maintenance/itemtype/update', 'MaintenanceController@postAdminItemTypeUpdate');
		Route::post('/admin/maintenance/itemtype/remove', 'MaintenanceController@postAdminItemTypeRemove');

		//item
		Route::name('admin-maintenance-item')->get('/admin/maintenance/item', 'MaintenanceController@getAdminItem');
		Route::post('/admin/maintenance/item/new', 'MaintenanceController@postAdminItemNew');
		Route::post('/admin/maintenance/item/update', 'MaintenanceController@postAdminItemUpdate');
		Route::post('/admin/maintenance/item/remove', 'MaintenanceController@postAdminItemRemove');

		//requirement
		Route::name('admin-maintenance-requirement')->get('/admin/maintenance/requirement', 'MaintenanceController@getAdminRequirement');
		Route::post('/admin/maintenance/requirement/new', 'MaintenanceController@postAdminRequirementNew');
		Route::post('/admin/maintenance/requirement/update', 'MaintenanceController@postAdminRequirementUpdate');
		Route::post('/admin/maintenance/requirement/remove', 'MaintenanceController@postAdminRequirementRemove');

		//commend
		Route::name('admin-maintenance-commend')->get('/admin/maintenance/commend', 'MaintenanceController@getAdminCommend');
		Route::post('/admin/maintenance/commend/new', 'MaintenanceController@postAdminCommendNew');
		Route::post('/admin/maintenance/commend/update', 'MaintenanceController@postAdminCommendUpdate');
		Route::post('/admin/maintenance/commend/remove', 'MaintenanceController@postAdminCommendRemove');

		//violation
		Route::name('admin-maintenance-violation')->get('/admin/maintenance/violation', 'MaintenanceController@getAdminViolation');
		Route::post('/admin/maintenance/violation/new', 'MaintenanceController@postAdminViolationNew');
		Route::post('/admin/maintenance/violation/update', 'MaintenanceController@postAdminViolationUpdate');
		Route::post('/admin/maintenance/violation/remove', 'MaintenanceController@postAdminViolationRemove');

		//multiple choice
		Route::name('admin-maintenance-multiplechoice')->get('/admin/maintenance/multiplechoice', 'MaintenanceController@getAdminMultipleChoice');
		Route::post('/admin/maintenance/multiplechoice/new', 'MaintenanceController@postAdminMultipleChoiceNew');
		Route::post('/admin/maintenance/multiplechoice/update', 'MaintenanceController@postAdminMultipleChoiceUpdate');
		Route::post('/admin/maintenance/multiplechoice/remove', 'MaintenanceController@postAdminMultipleChoiceRemove');

		//true or false
		Route::name('admin-maintenance-trueorfalse')->get('/admin/maintenance/trueorfalse', 'MaintenanceController@getAdminTrueOrFalse');
		Route::post('/admin/maintenance/trueorfalse/new', 'MaintenanceController@postAdminTrueOrFalseNew');
		Route::post('/admin/maintenance/trueorfalse/update', 'MaintenanceController@postAdminTrueOrFalseUpdate');
		Route::post('/admin/maintenance/trueorfalse/remove', 'MaintenanceController@postAdminTrueOrFalseRemove');

		//identification
		Route::name('admin-maintenance-identification')->get('/admin/maintenance/identification', 'MaintenanceController@getAdminIdentification');
		Route::post('/admin/maintenance/identification/new', 'MaintenanceController@postAdminIdentificationNew');
		Route::post('/admin/maintenance/identification/update', 'MaintenanceController@postAdminIdentificationUpdate');
		Route::post('/admin/maintenance/identification/remove', 'MaintenanceController@postAdminIdentificationRemove');

		//essay
		Route::name('admin-maintenance-essay')->get('/admin/maintenance/essay', 'MaintenanceController@getAdminEssay');
		Route::post('/admin/maintenance/essay/new', 'MaintenanceController@postAdminEssayNew');
		Route::post('/admin/maintenance/essay/update', 'MaintenanceController@postAdminEssayUpdate');
		Route::post('/admin/maintenance/essay/remove', 'MaintenanceController@postAdminEssayRemove');

		//test
		Route::name('admin-maintenance-test')->get('/admin/maintenance/test', 'MaintenanceController@getAdminTest');
		Route::post('/admin/maintenance/test/new', 'MaintenanceController@postAdminTestNew');
		Route::post('/admin/maintenance/test/update', 'MaintenanceController@postAdminTestUpdate');
		Route::post('/admin/maintenance/test/remove', 'MaintenanceController@postAdminTestRemove');

		//choice
		Route::post('/admin/maintenance/questionchoice/new', 'MaintenanceController@postAdminQuestionChoiceNew');
		Route::post('/admin/maintenance/questionchoice/update', 'MaintenanceController@postAdminQuestionChoiceUpdate');
		Route::post('/admin/maintenance/questionchoice/remove', 'MaintenanceController@postAdminQuestionChoiceRemove');

		//test question
		Route::get('/admin/maintenance/testquestion/in', 'MaintenanceController@getAdminTestQuestionIn');
		Route::get('/admin/maintenance/testquestion/out', 'MaintenanceController@getAdminTestQuestionOut');
		Route::post('/admin/maintenance/testquestion/new', 'MaintenanceController@postAdminTestQuestionNew');
		Route::post('/admin/maintenance/testquestion/remove', 'MaintenanceController@postAdminTestQuestionRemove');

		//query query query query query query query query query query query query query query query query query query
		Route::name('admin-query-securityguardscore')->get('/admin/query/securityguardscore', 'QueryController@getAdminSecurityGuardScore');
		Route::name('admin-query-securityguardvacant')->get('/admin/query/securityguardvacant', 'QueryController@getAdminSecurityGuardVacant');
		Route::name('admin-query-securityguardcommend')->get('/admin/query/securityguardcommend', 'QueryController@getAdminSecurityGuardCommend');
		Route::name('admin-query-securityguardviolation')->get('/admin/query/securityguardviolation', 'QueryController@getAdminSecurityGuardViolation');
		Route::name('admin-query-clientcontract')->get('/admin/query/clientcontract', 'QueryController@getAdminClientContract');
		Route::name('admin-query-deploymentsitearea')->get('/admin/query/deploymentsitearea', 'QueryController@getAdminDeploymentSiteArea');

		//utility utility utility utility utility utility utility utility utility utility utility utility utility utility utility utility 
		//appointment
		Route::name('admin-utility-appointment')->get('/admin/utility/appointment', 'UtilityController@getAdminAppointment');
		Route::post('/admin/utility/appointment', 'UtilityController@postAdminAppointment');
		Route::post('/admin/utility/holiday/new', 'UtilityController@postAdminHolidayNew');
		Route::post('/admin/utility/holiday/update', 'UtilityController@postAdminHolidayUpdate');
		Route::post('/admin/utility/holiday/remove', 'UtilityController@postAdminHolidayRemove');

		//archive archive archive archive archive archive archive archive archive archive archive archive archive archive archive archive
		//assessment topic
		Route::name('admin-archive-assessmenttopic')->get('/admin/archive/assessmenttopic', 'ArchiveController@getAdminArchiveAssessmentTopic');
		Route::post('/admin/archive/assessmenttopic/restore', 'ArchiveController@postAdminArchiveAssessmentTopicRestore');

		//industry type
		Route::name('admin-archive-industrytype')->get('/admin/archive/industrytype', 'ArchiveController@getAdminArchiveIndustryType');
		Route::post('/admin/archive/industrytype/restore', 'ArchiveController@postAdminArchiveIndustryTypeRestore');

		//requirement
		Route::name('admin-archive-requirement')->get('/admin/archive/requirement', 'ArchiveController@getAdminArchiveRequirement');
		Route::post('/admin/archive/requirement/restore', 'ArchiveController@postAdminArchiveRequirementRestore');

		//commend
		Route::name('admin-archive-commend')->get('/admin/archive/commend', 'ArchiveController@getAdminArchiveCommend');
		Route::post('/admin/archive/commend/restore', 'ArchiveController@postAdminArchiveCommendRestore');

		//violation
		Route::name('admin-archive-violation')->get('/admin/archive/violation', 'ArchiveController@getAdminArchiveViolation');
		Route::post('/admin/archive/violation/restore', 'ArchiveController@postAdminArchiveViolationRestore');

		//test
		Route::name('admin-archive-test')->get('/admin/archive/test', 'ArchiveController@getAdminArchiveTest');
		Route::post('/admin/archive/test/restore', 'ArchiveController@postAdminArchiveTestRestore');

		//item type
		Route::name('admin-archive-itemtype')->get('/admin/archive/itemtype', 'ArchiveController@getAdminArchiveItemType');
		Route::post('/admin/archive/itemtype/restore', 'ArchiveController@postAdminArchiveItemTypeRestore');

		//item
		Route::name('admin-archive-item')->get('/admin/archive/item', 'ArchiveController@getAdminArchiveItem');
		Route::post('/admin/archive/item/restore', 'ArchiveController@postAdminArchiveItemRestore');

		//area type
		Route::name('admin-archive-areatype')->get('/admin/archive/areatype', 'ArchiveController@getAdminArchiveAreaType');
		Route::post('/admin/archive/areatype/restore', 'ArchiveController@postAdminArchiveAreaTypeRestore');

		//question
		Route::name('admin-archive-question')->get('/admin/archive/question', 'ArchiveController@getAdminArchiveQuestion');
		Route::post('/admin/archive/question/change', 'ArchiveController@postAdminArchiveQuestionChange');
		Route::post('/admin/archive/question/restore', 'ArchiveController@postAdminArchiveQuestionRestore');

		//report report report report report report report report report report report report report report report report report report
		Route::name('admin-report-firearmlicense')->get('/admin/report/firearmlicense', 'ReportController@getAdminFirearmLicense');
		Route::name('admin-report-securitylicense')->get('/admin/report/securitylicense', 'ReportController@getAdminSecurityLicense');
		Route::name('admin-report-equipment')->get('/admin/report/equipment', 'ReportController@getAdminEquipment');
		Route::name('admin-report-ddo')->get('/admin/report/ddo', 'ReportController@getAdminDDO');
		Route::name('admin-report-mdr')->get('/admin/report/mdr', 'ReportController@getAdminMDR');
	});

	//client client client client client client client client client client client client client client client client client client 
	Route::group(['middleware' => 'Amcor\Http\Middleware\ClientMiddleware'], function() {
		//deployment site
		Route::name('client-deploymentsite')->get('/client/deploymentsite', 'DeploymentSiteController@getClientDeploymentSite');
		Route::get('/client/deploymentsite/qualification/validate', 'DeploymentSiteController@getClientQualificationValidate');
		Route::post('/client/deploymentsite/qualification/new', 'DeploymentSiteController@postClientQualificationNew');
		Route::get('/client/deploymentsite/securityguard/list', 'DeploymentSiteController@getClientSecurityGuardList');
		Route::post('/client/deploymentsite/securityguard/list', 'DeploymentSiteController@postClientSecurityGuardList');

		Route::get('/client/deploymentsite/item/get', 'DeploymentSiteController@getClientItemGet');
		Route::get('/client/deploymentsite/firearm/get', 'DeploymentSiteController@getClientFirearmGet');
		Route::post('/client/deploymentsite/item', 'DeploymentSiteController@postClientItem');

		//manager
		Route::name('client-manager')->get('/client/manager', 'ManagerController@getClientManager');
		Route::post('/client/manager/new', 'ManagerController@postClientManagerNew');
		Route::post('/client/manager/update', 'ManagerController@postClientManagerUpdate');
		Route::post('/client/manager/update-account', 'ManagerController@postClientManagerUpdateAccount');
		Route::post('/client/manager/remove', 'ManagerController@postClientManagerRemove');

		Route::get('/client/manager/deploymentsite', 'ManagerController@getClientDeploymentSite');
		Route::get('/client/manager/assigndeploymentsite', 'ManagerController@getClientAssignDeploymentSite');
		Route::post('/client/manager/deploymentsite', 'ManagerController@postClientDeploymentSite');
		Route::post('/client/manager/assigndeploymentsite', 'ManagerController@postClientAssignDeploymentSite');

		//request
		Route::name('client-request')->get('/client/request', 'RequestController@getClientRequest');
		Route::get('/client/request/deploymentsite', 'RequestController@getClientDeploymentSite');
		Route::post('/client/request/remove', 'RequestController@postClientRemove');

		Route::get('/client/request/item', 'RequestController@getClientItem');
		Route::post('/client/request/item', 'RequestController@postClientItem');
		Route::get('/client/request/item/get', 'RequestController@getClientItemGet');
		Route::get('/client/request/firearm/get', 'RequestController@getClientFirearmGet');
		Route::post('/client/request/item/receive', 'RequestController@postClientItemReceive');

		Route::post('/client/request/clientqualification', 'RequestController@postClientClientQualification');
		Route::get('/client/request/securityguard/list', 'RequestController@getClientSecurityGuardList');
		Route::post('/client/request/securityguard/list', 'RequestController@postClientSecurityGuardList');

		//report
		Route::name('client-report')->get('/client/report', 'ReportController@getClientReport');
	});

	//manager manager manager manager manager manager manager manager manager manager manager manager manager manager manager manager
	Route::group(['middleware' => 'Amcor\Http\Middleware\ManagerMiddleware'], function() {
		//attendance
		Route::name('manager-attendance')->get('/manager/attendance', 'AttendanceController@getManagerAttendance');
		Route::get('/manager/attendance/securityguard', 'AttendanceController@getManagerSecurityGuard');
		Route::post('/manager/attendance/securityguard', 'AttendanceController@postManagerSecurityGuard');
	});

	//applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant applicant
	Route::group(['middleware' => 'Amcor\Http\Middleware\ApplicantMiddleware'], function() {
		//appointment
		Route::name('applicant-appointment')->get('/applicant/appointment', 'AppointmentController@getApplicantAppointment');
		Route::get('/applicant/appointmentdate', 'AppointmentController@getApplicantAppointmentDate');
		Route::post('/applicant/appointment/set', 'AppointmentController@postApplicantAppointmentSet');

		Route::name('applicant-appointment-voucher')->get('/applicant/appointment/voucher', 'PDFController@getApplicantAppointmentVoucher');
		Route::post('/applicant/appointment/remove', 'AppointmentController@postApplicantAppointmentRemove');
	});


});