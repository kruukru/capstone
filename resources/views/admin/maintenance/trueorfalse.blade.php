@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - True or False</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New True or False</button><hr>
						<table id="tblTrueorFalse" class="table table-striped table-bordered">
							<thead>
								<th>Question</th>
								<th>Answer</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="question-list">
								@foreach ($questions as $question)
								<tr id="id{{$question->questionid}}">
									<td>{{$question->question}}</td>
									<td>{{$question->choice[0]->answer}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$question->questionid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$question->questionid}}">Remove</button>
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
	<div class="modal fade" id="modalTrueOrFalse">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formTrueOrFalse" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Question <span class="asterisk-red">*</span></label>
							<textarea id="inputQuestion" rows="3" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Correct Answer <span class="asterisk-red">*</span></label><br>
							<label><input type="radio" name="cbCorrect" id="cbCorrect" value="True" checked> True</label><br>
							<label><input type="radio" name="cbCorrect" id="cbCorrect" value="False"> False</label>
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
	<div class="modal fade" id="modalTrueOrFalseRemove">
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
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/maintenance/trueorfalse.js"></script>
@endsection