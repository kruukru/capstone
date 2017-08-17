@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - Question</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button style="float: left;" id="btnNew" class="btn btn-primary btn-md">New Question</button>
						<form id="formSearch" data-parsley-validate>
							<div class="input-group input-group-sm pull-right" style="width: 300px;">
								<input type="text" id="search" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" id="btnSearch"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</form>
						<table class="table table-striped">
							<thead>
								<th>Question</th>
								<th style="float: right; padding-right: 90px">Action</th>
							</thead>
							<tbody id="question-list">
								@foreach ($questions as $question)
								<tr id="id{{$question->questionid}}">
									<td>{{$question->question}}</td>
									<td style="float: right;">
										<button class="btn btn-primary btn-xs" id="btnAddRemoveChoice" value="{{$question->questionid}}">Add/Remove Choice</button>
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$question->questionid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$question->questionid}}">Remove</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					<div class="pull-right">{!! $questions->render() !!}</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for new and update -->
	<div class="modal fade" id="modalQuestion">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4 id="modalTitle">XXX</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<form id="formQuestion" data-parsley-validate>
						<div class="form-group">
							<label>Question *</label>
							<textarea id="inputQuestion" rows="3" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<button id="btnSave" value="New" class="btn btn-success btn-block">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for add/remove choice -->
	<div class="modal fade" id="modalChoice">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4>Add/Remove Choice</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<form id="formQuestion" data-parsley-validate>
						<div class="form-group">
							<label>Question:</label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label id="outputQuestion"></label>
						</div><hr>
						<div class="form-group">
							<label>Choice</label>
							<input type="text" class="form-control" id="inputChoice" required><br>
							<label><input type="checkbox" name="cbCorrect" id="cbCorrect"> CORRECT</label>
							<div class="pull-right">
								<button class="btn btn-primary btn-block" id="btnChoiceAdd">Add Choice</button>
							</div>
						</div>
						<div class="form-group">
							<table class="table table-striped" id="tblChoice">
								<thead>
									<th>Choice</th>
									<th>Answer</th>
									<th class="pull-right" style="padding-right: 15px;">Action</th>
								</thead>
								<tbody id="choice-list"></tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button id="btnChoiceSave" class="btn btn-success">Save</button>
							<button class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for choice error -->
	<div class="modal fade" id="modalChoiceError">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4>ERROR</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					You must have one(1) correct choice!!
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
        			<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalQuestionRemove">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4 id="modalTitle">CONFIRMATION</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to remove this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">Confirm</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for remove error -->
	<div class="modal fade" id="modalQuestionRemoveError">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4 id="modalTitle">ERROR</h4>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Cannot remove this question while it's being used!!
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
        			<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/maintenance/question.js"></script>
@endsection