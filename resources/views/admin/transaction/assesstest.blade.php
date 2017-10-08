@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Assess Test</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblAssessTest" class="table table-striped table-bordered">
							<thead>
								<th>Applicant No.</th>
								<th>Name</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="applicant-list">
								@foreach ($applicants as $applicant)
								<tr id="id{{$applicant->applicantid}}">
									<td>{{$applicant->applicantid}}</td>
									<td>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
									@if ($applicant->status == 2 || $applicant->status == 6)
										<td style="text-align: center;">
											<button class="btn btn-warning btn-xs" id="btnAssess" value="{{$applicant->applicantid}}">Assess</button>
										</td>
									@else
										<td style="text-align: center;">
											<a href="{{ route('admin-testresult-document', ['applicantid' => $applicant->applicantid]) }}"><button class="btn btn-primary btn-xs">Test Result</button></a>
										</td>
									@endif 
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
	<div class="modal fade" id="modalAssess">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Assess Test</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label>Applicant Name:</label>
						<h3 id="applicantName">Name</h3>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Test</h3>
						<table class="table table-striped table-bordered" id="tblPassFail">
							<thead>
								<th>Test</th>
								<th style="text-align: center;">Score</th>
								<th style="text-align: center;">Percent</th>
							</thead>
							<tbody></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Essay</h3>
						<table class="table table-striped table-bordered" id="tblEssay">
							<thead>
								<th>Question/Topic</th>
								<th>Answer</th>
							</thead>
							<tbody></tbody>
						</table>
					</div><hr>
					<div class="form-group">
						<div class="col-md-offset-1">
							<h3>Test Assessment</h3>
						</div>
					</div>
					<form id="formAssessment" data-parsley-validate>
						<div class="form-group">
							<div class="row">
								<div class="col-md-8 col-md-offset-1">
									<label>Topic <span class="asterisk-red">*</span></label>
									<select class="form-control" id="assessmenttopic" required></select>
								</div>
								<div class="col-md-2">
									<button id="btnAdd" class="btn btn-primary col-md-12">ADD</button>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<label>Remarks <span class="asterisk-red">*</span></label>
									<textarea id="inputAssessment" class="form-control col-md-11" rows="3" required></textarea>
								</div>
							</div>
						</div>
					</form>
					<div class="form-group table-responsive">
						<table class="table table-striped table-bordered" id="tblAssessment">
							<thead>
								<th>Topic</th>
								<th>Remarks</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="assessment-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnSave">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
	<meta name="AuthenticatedID" content="{{ Auth::user()->admin->adminid }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/assesstest.js"></script>
@endsection