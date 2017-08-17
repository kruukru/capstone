@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Archive - Question</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<select class="form-control" id="cbQuestionType" style="width: 15%;">
							<option value="">All</option>
							<option value="0">Multiple Choice</option>
							<option value="1">True or False</option>
							<option value="2">Identification</option>
							<option value="3">Essay</option>
						</select><hr>
						<table id="tblQuestion" class="table table-striped table-bordered">
							<thead>
								<th>ID</th>
								<th>Question</th>
								<th>Removed At</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="question-list">
								@foreach ($questions as $question)
								<tr id="id{{$question->questionid}}">
									<td>{{$question->questionid}}</td>
									<td>{{$question->question}}</td>
									<td>{{$question->deleted_at}}</td>
									<td style="text-align: center;">
										<button class="btn btn-success btn-xs" id="btnRestore" value="{{$question->questionid}}">Restore</button>
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

	<!-- modal for remove -->
	<div class="modal fade" id="modalQuestion">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to restore this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnRestoreConfirm">CONFIRM</button>
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
	<script src="/js/custom/admin/archive/question.js"></script>
@endsection