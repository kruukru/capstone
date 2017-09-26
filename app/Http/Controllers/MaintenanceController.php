<?php

namespace Amcor\Http\Controllers;

use Illuminate\Http\Request;
use Amcor\ItemType;
use Amcor\Item;
use Amcor\Requirement;
use Amcor\Violation;
use Amcor\Question;
use Amcor\Choice;
use Amcor\Test;
use Amcor\TestQuestion;
use Amcor\AppointmentSlot;
use Amcor\AssessmentTopic;
use Amcor\Commend;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;
use Response;

class MaintenanceController extends Controller
{
    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin 
    //new question choice
    public function postAdminQuestionChoiceNew(Request $request) {
        foreach ($request->formData as $data) {
            $choice = new Choice;
            $choice->questionid = $request->inputQuestionID;
            $choice->answer = $data['inputChoice'];
            $choice->iscorrect = $data['inputAnswer'];
            $choice->save();
        }

        return Response::json($choice);
    }

    //update question choice
    public function postAdminQuestionChoiceUpdate(Request $request) {
        foreach ($request->formData as $data) {
            $choice = Choice::where('questionid', $request->inputQuestionID)->first();
            $choice->answer = $data['inputChoice'];
            $choice->iscorrect = $data['inputAnswer'];
            $choice->save();
        }

        return Response::json($choice);
    }

    //remove question choice
    public function postAdminQuestionChoiceRemove(Request $request) {
        Choice::where('questionid', $request->inputQuestionID)->forceDelete();
    }


    //new question to the test
    public function postAdminTestQuestionNew(Request $request) {
        $test = Test::find($request->inputTestID);
        $question = Question::find($request->inputQuestionID);
        $testquestion = new TestQuestion;

        $testquestion->test()->associate($test);
        $testquestion->question()->associate($question);
        $testquestion->save();

        return Response::json($question);
    }

    //remove question to the test
    public function postAdminTestQuestionRemove(Request $request) {
        $testquestion = TestQuestion::where('testid', $request->inputTestID)
            ->where('questionid', $request->inputQuestionID);
        $question = Question::find($request->inputQuestionID);

        $testquestion->delete();

        return Response::json($question);
    }

    //getting all the test question IN
    public function getAdminTestQuestionIn(Request $request) {
        $testquestion = TestQuestion::where('testid', $request->inputTestID)
            ->pluck('questionid')
            ->all();
        $question = Question::where('type', $request->inputQuestionType)
            ->whereIn('questionid', $testquestion)
            ->get();

        return Response::json($question);
    }

    //getting all the test question OUT
    public function getAdminTestQuestionOut(Request $request) {
        $testquestion = TestQuestion::pluck('questionid')->all();
        $question = Question::where('type', $request->inputQuestionType)
            ->whereNotIn('questionid', $testquestion)->get();

        return Response::json($question);
    }

    //assessment topic assessment topic assessment topic assessment topic assessment topic assessment topic
    public function getAdminAssessmentTopic() {
        $assessmenttopics = AssessmentTopic::get();

        return view('admin.maintenance.assessmenttopic', compact('assessmenttopics'));
    }

    public function postAdminAssessmentTopicNew(Request $request) {
        $assessmenttopic = AssessmentTopic::withTrashed()
            ->where('name', $request->inputAssessmentTopic)
            ->first();

        if ($assessmenttopic === null) {
            $assessmenttopic = new AssessmentTopic;
            $assessmenttopic->name = $request->inputAssessmentTopic;
            $assessmenttopic->description = $request->inputAssessmentTopicDescription;
            $assessmenttopic->save();
        } else {
            if ($assessmenttopic->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($assessmenttopic);
    }

    public function postAdminAssessmentTopicUpdate(Request $request) {
        $assessmenttopic = AssessmentTopic::withTrashed()
            ->where([
                ['name', $request->inputAssessmentTopic],
                ['assessmenttopicid', '!=', $request->inputAssessmentTopicID],
            ])->first();

        if ($assessmenttopic === null) {
            $assessmenttopic = AssessmentTopic::find($request->inputAssessmentTopicID);
            $assessmenttopic->name = $request->inputAssessmentTopic;
            $assessmenttopic->description = $request->inputAssessmentTopicDescription;
            $assessmenttopic->save();
        } else {
            if ($assessmenttopic->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($assessmenttopic);
    }

    public function postAdminAssessmentTopicRemove(Request $request) {
        $assessmenttopic = AssessmentTopic::find($request->inputAssessmentTopicID);

        if (count($assessmenttopic->testassessment) || count($assessmenttopic->interviewassessment)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $assessmenttopic->delete();
        }

        return Response::json($assessmenttopic);
    }

    //item type item type item type item type item type item type item type item type item type item type 
    public function getAdminItemType() {
        $itemtypes = ItemType::get();

        return view('admin.maintenance.itemtype', compact('itemtypes'));
    }

    public function postAdminItemTypeNew(Request $request) {
        $itemtype = ItemType::withTrashed()
            ->where('name', $request->inputItemType)
            ->first();

        if ($itemtype === null) {
            $itemtype = new ItemType;
            $itemtype->name = $request->inputItemType;
            $itemtype->description = $request->inputItemTypeDescription;
            $itemtype->save();
        } else {
            if ($itemtype->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($itemtype);
    }

    public function postAdminItemTypeUpdate(Request $request) {
        $itemtype = ItemType::withTrashed()
            ->where([
                ['name', $request->inputItemType],
                ['itemtypeid', '!=', $request->inputItemTypeID],
            ])->first();

        if ($itemtype === null) {
            $itemtype = ItemType::find($request->inputItemTypeID);
            $itemtype->name = $request->inputItemType;
            $itemtype->description = $request->inputItemTypeDescription;
            $itemtype->save();
        } else {
            if ($itemtype->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($itemtype);

    }

    public function postAdminItemTypeRemove(Request $request) {
        $itemtype = ItemType::find($request->inputItemTypeID);

        if (count($itemtype->item()->withTrashed()->get())) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $itemtype->delete();
        }

        return Response::json($itemtype);
    }

    //item item item item item item item item item item item item item item item item item item item item 
    public function getAdminItem() {
        $items = Item::get();

        return view('admin.maintenance.item', compact('items'));
    }

    public function postAdminItemNew(Request $request) {
        $item = Item::withTrashed()
            ->where('name', $request->inputItem)
            ->first();

        if ($item === null) {
            $itemtype = ItemType::find($request->inputItemType);
            $item = new Item;
            $item->itemtype()->associate($itemtype);
            $item->name = $request->inputItem;
            $item->description = $request->inputItemDescription;
            $item->qty = 0;
            $item->qtyavailable = 0;
            $item->save();
        } else {
            if ($item->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($item);
    }

    public function postAdminItemUpdate(Request $request) {
        $item = Item::withTrashed()
            ->where([
                ['name', $request->inputItem],
                ['itemid', '!=', $request->inputItemID],
            ])->first();

        if ($item === null) {
            $itemtype = ItemType::find($request->inputItemType);
            $item = Item::find($request->inputItemID);
            $item->itemtype()->associate($itemtype);
            $item->name = $request->inputItem;
            $item->description = $request->inputItemDescription;
            $item->save();
        } else {
            if ($item->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($item);
    }

    public function postAdminItemRemove(Request $request) {
        $item = Item::find($request->inputItemID);

        if (count($item->firearm) || count($item->issueditem) || count($item->requestitem)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $item->delete();
        }

        return Response::json($item);
    }

    //requirement requirement requirement requirement requirement requirement requirement requirement 
    public function getAdminRequirement() {
        $requirements = Requirement::get();

        return view('admin.maintenance.requirement', compact('requirements'));
    }

    public function postAdminRequirementNew(Request $request) {
        $requirement = Requirement::withTrashed()
            ->where('name', $request->inputRequirement)
            ->first();

        if ($requirement === null) {
            $requirement = new Requirement;
            $requirement->name = $request->inputRequirement;
            $requirement->description = $request->inputRequirementDescription;
            $requirement->save();
        } else {
            if ($requirement->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($requirement);
    }

    public function postAdminRequirementUpdate(Request $request) {
        $requirement = Requirement::withTrashed()
            ->where([
                ['name', $request->inputRequirement],
                ['requirementid', '!=', $request->inputRequirementID],
            ])->first();

        if ($requirement === null) {
            $requirement = Requirement::find($request->inputRequirementID);
            $requirement->name = $request->inputRequirement;
            $requirement->description = $request->inputRequirementDescription;
            $requirement->save();
        } else {
            if ($requirement->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($requirement);
    }

    public function postAdminRequirementRemove(Request $request) {
        $requirement = Requirement::find($request->inputRequirementID);

        if (count($requirement->applicantrequirement()->get())) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $requirement->delete();
        }
            
        return Response::json($requirement);
    }

    //commend commend commend commend commend commend commend commend commend commend commend commend commend commend commend 
    public function getAdminCommend() {
        $commends = Commend::get();

        return view('admin.maintenance.commend', compact('commends'));
    }

    public function postAdminCommendNew(Request $request) {
        $commend = Commend::withTrashed()
            ->where('name', $request->inputCommend)
            ->first();

        if ($commend === null) {
            $commend = new Commend;
            $commend->name = $request->inputCommend;
            $commend->description = $request->inputCommendDescription;
            $commend->save();
        } else {
            if ($commend->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($commend);
    }

    public function postAdminCommendUpdate(Request $request) {
        $commend = Commend::withTrashed()
            ->where([
                ['name', $request->inputCommend],
                ['commendid', '!=', $request->inputCommendID],
            ])->first();

        if ($commend === null) {
            $commend = Commend::find($request->inputCommendID);
            $commend->name = $request->inputCommend;
            $commend->description = $request->inputCommendDescription;
            $commend->save();
        } else {
            if ($commend->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($commend);
    }

    public function postAdminCommendRemove(Request $request) {
        $commend = Commend::find($request->inputCommendID);
        $commend->delete();

        return Response::json($commend);
    }

    //violation violation violation violation violation violation violation violation violation violation
    public function getAdminViolation() {
        $violations = Violation::get();

        return view('admin.maintenance.violation', compact('violations'));
    } 

    public function postAdminViolationNew(Request $request) {
        $violation = Violation::withTrashed()
            ->where('name', $request->inputViolation)
            ->first();

        if ($violation === null) {
            $violation = new Violation;
            $violation->name = $request->inputViolation;
            $violation->severity = $request->inputViolationSeverity;
            $violation->description = $request->inputViolationDescription;
            $violation->save();
        } else {
            if ($violation->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($violation);
    }

    public function postAdminViolationUpdate(Request $request) {
        $violation = Violation::withTrashed()
            ->where([
                ['name', $request->inputViolation],
                ['violationid', '!=', $request->inputViolationID],
            ])->first();

        if ($violation === null) {
            $violation = Violation::find($request->inputViolationID);
            $violation->name = $request->inputViolation;
            $violation->severity = $request->inputViolationSeverity;
            $violation->description = $request->inputViolationDescription;
            $violation->save();
        } else {
            if ($violation->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($violation);
    }

    public function postAdminViolationRemove(Request $request) {
        $violation = Violation::find($request->inputViolationID);
        $violation->delete();

        return Response::json($violation);
    }

    //test test test test test test test test test test test test test test test test test test test 
    public function getAdminTest() {
        $tests = Test::get();

        return view('admin.maintenance.test', compact('tests'));
    }

    public function postAdminTestNew(Request $request) {
        $test = Test::withTrashed()
            ->where('name', $request->inputTest)
            ->first();

        if ($test === null) {
            $test = new Test;
            $test->name = $request->inputTest;
            $test->instruction = $request->inputInstruction;
            $test->maxquestion = $request->inputMaxQuestion;
            $test->timealloted = $request->inputTimeAlloted;
            $test->save();
        } else {
            if ($test->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($test);
    }

    public function postAdminTestUpdate(Request $request) {
        $test = Test::withTrashed()
            ->where([
                ['name', $request->inputTest],
                ['testid', '!=', $request->inputTestID],
            ])->first();

        if ($test === null) {
            $test = Test::find($request->inputTestID);
            $test->name = $request->inputTest;
            $test->instruction = $request->inputInstruction;
            $test->maxquestion = $request->inputMaxQuestion;
            $test->timealloted = $request->inputTimeAlloted;
            $test->save();
        } else {
            if ($test->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($test);
    }

    public function postAdminTestRemove(Request $request) {
        $test = Test::find($request->inputTestID);

        if (count($test->testquestion) || count($test->score)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $test->testquestion()->forceDelete();
            $test->delete();
        }

        return Response::json($test);
    }

    //question question question question question question question question question question question question question 
    //multiple choice multiple choice multiple choice multiple choice multiple choice multiple choice multiple choice
    public function getAdminMultipleChoice() {
        $questions = Question::where('type', 0)->get();

        return view('admin.maintenance.multiplechoice', compact('questions'));
    }

    public function postAdminMultipleChoiceNew(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 0],
            ['question', $request->inputQuestion],
        ])->first();

        if ($question === null) {
            $question = new Question;
            $question->question = $request->inputQuestion;
            $question->type = 0;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminMultipleChoiceUpdate(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 0],
            ['question', $request->inputQuestion],
            ['questionid', '!=', $request->inputQuestionID],
        ])->first();

        if ($question === null) {
            $question = Question::find($request->inputQuestionID);
            $question->question = $request->inputQuestion;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminMultipleChoiceRemove(Request $request) {
        $question = Question::find($request->inputQuestionID);

        if (count($question->testquestion)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            Choice::where('questionid', $request->inputQuestionID)->delete();
            $question->delete();
        }

        return Response::json($question);
    }

    //true or false true or false true or false true or false true or false true or false true or false true or false 
    public function getAdminTrueOrFalse() {
        $questions = Question::with('Choice')->where('type', 1)->get();

        return view('admin.maintenance.trueorfalse', compact('questions'));
    }

    public function postAdminTrueOrFalseNew(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 1],
            ['question', $request->inputQuestion],
        ])->first();

        if ($question === null) {
            $question = new Question;
            $question->question = $request->inputQuestion;
            $question->type = 1;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminTrueOrFalseUpdate(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 1],
            ['question', $request->inputQuestion],
            ['questionid', '!=', $request->inputQuestionID],
        ])->first();

        if ($question === null) {
            $question = Question::find($request->inputQuestionID);
            $question->question = $request->inputQuestion;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminTrueOrFalseRemove(Request $request) {
        $question = Question::find($request->inputQuestionID);

        if (count($question->testquestion)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            Choice::where('questionid', $request->inputQuestionID)->delete();
            $question->delete();
        }

        return Response::json($question);
    }

    //identification identification identification identification identification identification identification 
    public function getAdminIdentification() {
        $questions = Question::with('Choice')->where('type', 2)->get();

        return view('admin.maintenance.identification', compact('questions'));
    }

    public function postAdminIdentificationNew(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 2],
            ['question', $request->inputQuestion],
        ])->first();

        if ($question === null) {
            $question = new Question;
            $question->question = $request->inputQuestion;
            $question->type = 2;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminIdentificationUpdate(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 2],
            ['question', $request->inputQuestion],
            ['questionid', '!=', $request->inputQuestionID],
        ])->first();

        if ($question === null) {
            $question = Question::find($request->inputQuestionID);
            $question->question = $request->inputQuestion;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminIdentificationRemove(Request $request) {
        $question = Question::find($request->inputQuestionID);

        if (count($question->testquestion)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            Choice::where('questionid', $request->inputQuestionID)->delete();
            $question->delete();
        }

        return Response::json($question);
    }

    //essay essay essay essay essay essay essay essay essay essay essay essay essay essay essay essay 
    public function getAdminEssay() {
        $questions = Question::where('type', 3)->get();

        return view('admin.maintenance.essay', compact('questions'));
    }

    public function postAdminEssayNew(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 3],
            ['question', $request->inputQuestion],
        ])->first();

        if ($question === null) {
            $question = new Question;
            $question->question = $request->inputQuestion;
            $question->type = 3;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminEssayUpdate(Request $request) {
        $question = Question::withTrashed()->where([
            ['type', 3],
            ['question', $request->inputQuestion],
            ['questionid', '!=', $request->inputQuestionID],
        ])->first();

        if ($question === null) {
            $question = Question::find($request->inputQuestionID);
            $question->question = $request->inputQuestion;
            $question->save();
        } else {
            if ($question->deleted_at === null) {
                return Response::json("SAME NAME", 500);
            } else {
                return Response::json("SAME NAME TRASH", 500);
            }
        }

        return Response::json($question);
    }

    public function postAdminEssayRemove(Request $request) {
        $question = Question::find($request->inputQuestionID);

        if (count($question->testquestion)) {
            return Response::json("CANNOT REMOVE", 500);
        } else {
            $question->delete();
        }

        return Response::json($question);
    }
}
