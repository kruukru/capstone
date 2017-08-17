<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\Requirement;
use Amcor\Violation;
use Amcor\ItemType;
use Amcor\Item;
use Amcor\AreaType;
use Amcor\Test;
use Amcor\Question;
use Amcor\Choice;
use Amcor\AssessmentTopic;
use Amcor\Commend;
use Response;

class ArchiveController extends Controller
{
    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
    //test test test test test test test test test test test test test test test test test test test test test test test 
    public function getAdminArchiveTest() {
        $tests = Test::onlyTrashed()->get();

        return view('admin.archive.test', compact('tests'));
    }

    public function postAdminArchiveTestRestore(Request $request) {
        $test = Test::onlyTrashed()->find($request->inputTestID)->restore();

        return Response::json($test);
    }

    //assessment topic assessment topic assessment topic assessment topic assessment topic assessment topic assessment topic 
    public function getAdminArchiveAssessmentTopic() {
        $assessmenttopics = AssessmentTopic::onlyTrashed()->get();

        return view('admin.archive.assessmenttopic', compact('assessmenttopics'));
    }

    public function postAdminArchiveAssessmentTopicRestore(Request $request) {
        $assessmenttopic = AssessmentTopic::onlyTrashed()->find($request->inputAssessmentTopicID)->restore();

        return Response::json($assessmenttopic);
    }

    //requirement requirement requirement requirement requirement requirement requirement requirement requirement requirement 
    public function getAdminArchiveRequirement() {
    	$requirements = Requirement::onlyTrashed()->get();

    	return view('admin.archive.requirement', compact('requirements'));
    }

    public function postAdminArchiveRequirementRestore(Request $request) {
    	$requirement = Requirement::onlyTrashed()->find($request->inputRequirementID)->restore();

    	return Response::json($requirement);
    }

    //commend commend commend commend commend commend commend commend commend commend commend commend commend commend commend 
    public function getAdminArchiveCommend() {
        $commends = Commend::onlyTrashed()->get();

        return view('admin.archive.commend', compact('commends'));
    }

    public function postAdminArchiveCommendRestore(Request $request) {
        $commend = Commend::onlyTrashed()->find($request->inputCommendID)->restore();

        return Response::json($commend);
    }

    //violation violation violation violation violation violation violation violation violation violation violation 
    public function getAdminArchiveViolation() {
    	$violations = Violation::onlyTrashed()->get();

    	return view('admin.archive.violation', compact('violations'));
    }

    public function postAdminArchiveViolationRestore(Request $request) {
    	$violation = Violation::onlyTrashed()->find($request->inputViolationID)->restore();

    	return Response::json($violation);
    }

    //item type item type item type item type item type item type item type item type item type item type item type 
    public function getAdminArchiveItemType() {
    	$itemtypes = ItemType::onlyTrashed()->get();

    	return view('admin.archive.itemtype', compact('itemtypes'));
    }

    public function postAdminArchiveItemTypeRestore(Request $request) {
    	$itemtype = ItemType::onlyTrashed()->find($request->inputItemTypeID)->restore();

    	return Response::json($itemtype);
    }

    //item item item item item item item item item item item item item item item item item item item item item item 
    public function getAdminArchiveItem() {
    	$items = Item::onlyTrashed()->with('ItemType')->get();

    	return view('admin.archive.item', compact('items'));
    }

    public function postAdminArchiveItemRestore(Request $request) {
    	$item = Item::onlyTrashed()->find($request->inputItemID)->restore();

    	return Response::json($item);
    }

    //area type area type area type area type area type area type area type area type area type area type area type 
    public function getAdminArchiveAreaType() {
    	$areatypes = AreaType::onlyTrashed()->get();

    	return view('admin.archive.areatype', compact('areatypes'));
    }

    public function postAdminArchiveAreaTypeRestore(Request $request) {
    	$areatype = AreaType::onlyTrashed()->find($request->inputAreaTypeID)->restore();

    	return Response::json($areatype);
    }

    //test type test type test type test type test type test type test type test type test type test type test type 
    public function getAdminArchiveTestType() {
    	$testtypes = TestType::onlyTrashed()->get();

    	return view('admin.archive.testtype', compact('testtypes'));
    }

    public function postAdminArchiveTestTypeRestore(Request $request) {
    	$testtype = TestType::onlyTrashed()->find($request->inputTestTypeID)->restore();

    	return Response::json($testtype);
    }

    //question question question question question question question question question question question question 
    public function getAdminArchiveQuestion() {
    	$questions = Question::onlyTrashed()->get();

    	return view('admin.archive.question', compact('questions'));
    }

    public function postAdminArchiveQuestionChange(Request $request) {
    	if($request->inputQuestionType == "") {
    		$question = Question::onlyTrashed()->get();
    	} else {
    		$question = Question::onlyTrashed()->where('type', $request->inputQuestionType)->get();
    	}

        return Response::json($question);
    }

    public function postAdminArchiveQuestionRestore(Request $request) {
    	$question = Question::onlyTrashed()->find($request->inputQuestionID)->restore();
    	Choice::onlyTrashed()->where('questionid', $request->inputQuestionID)
    		->restore();

    	return Response::json($question);
    }
}
