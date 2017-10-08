@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - Test Form</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New Test Form</button><hr>
						<table id="tblTest" class="table table-striped table-bordered">
							<thead>
								<th>Test</th>
								<th>Instruction</th>
								<th style="text-align: center;">Max Question</th>
								<th style="text-align: center;">Time Alloted (minutes)</th>
								<th style="text-align: center;">Add/Remove Question</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="test-list">
								@foreach ($tests as $test)
								<tr id="id{{$test->testid}}">
									<td>{{$test->name}}</td>
									<td>{{$test->instruction}}</td>
									<td style="text-align: center;">{{$test->maxquestion}}</td>
									<td style="text-align: center;">{{$test->timealloted}}</td>
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnMultipleChoice" value="{{$test->testid}}">Multiple Choice</button>
										<button class="btn btn-primary btn-xs" id="btnTrueOrFalse" value="{{$test->testid}}">True or False</button>
										<button class="btn btn-primary btn-xs" id="btnIdentification" value="{{$test->testid}}">Identification</button>
										<button class="btn btn-primary btn-xs" id="btnEssay" value="{{$test->testid}}">Essay</button>
									</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$test->testid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$test->testid}}">Remove</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for new and update -->
	<div class="modal fade" id="modalTest">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formTest" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Test <span class="asterisk-red">*</span></label>
							<input type="text" id="inputTest" class="form-control" maxlength="100" required>
						</div>
						<div class="form-group">
							<label>Instruction <span class="asterisk-red">*</span></label>
							<textarea id="inputInstruction" rows="3" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Max Question <span class="asterisk-red">*</span></label>
									<input type="text" id="inputMaxQuestion" class="form-control" maxlength="3" style="text-align: right;" pattern="^[1-9][0-9]*$" required>
								</div>
								<div class="col-md-6">
									<label>Time Alloted <span class="asterisk-red">*</span></label>
									<div class="column">
										<div class="col-md-6 no-padding">
			            					<input type="text" id="inputTimeAlloted" class="form-control" maxlength="5" style="text-align: right;" pattern="^[1-9][0-9]*$" required>
			            				</div>
			            				<div class="col-md-6 no-padding">
			            					<select class="form-control" id="timeallotedtype">
					              				<option value="minute">minute(s)</option>
					              				<option value="hour">hour(s)</option>
					              			</select>
					              		</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button id="btnSave" value="New" class="btn btn-primary">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalTestRemove">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to remove this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for add/remove question -->
	<div class="modal fade" id="modalTestQuestion">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Add/Remove Question</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<h3 style="text-align: center;">QUESTION IN THE TEST</h3>
					<table id="tblQuestionIN" class="table table-striped table-bordered">
						<thead>
							<th>QUESTION</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="questionin-list"></tbody>
					</table><hr>
					<h3 style="text-align: center;">QUESTION BANK</h3>
					<table id="tblQuestionOUT" class="table table-striped table-bordered">
						<thead>
							<th>QUESTION</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="questionout-list"></tbody>
					</table>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/maintenance/test.js"></script>
@endsection