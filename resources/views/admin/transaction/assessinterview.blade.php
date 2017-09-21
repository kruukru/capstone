@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Assess Interview</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblAssessInterview" class="table table-striped table-bordered">
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
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnAssess" value="{{$applicant->applicantid}}">Assess</button>
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
	<div class="modal fade" id="modalAssess">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Assess Interview</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label>Applicant Name:</label>
						<h3 id="applicantName">Name</h3>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Test Assessment</h3>
						<table id="tblTestAssessment" class="table table-striped table-bordered">
							<thead>
								<th>Topic</th>
								<th>Message</th>
							</thead>
							<tbody id="testassessment-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group">
						<div class="col-md-offset-1">
							<h3>Interview Assessment</h3>
						</div>
					</div>
					<form id="formAssessment" data-parsley-validate>
						<div class="form-group">
							<div class="row">
								<div class="col-md-8 col-md-offset-1">
									<label>Topic *</label>
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
									<label>Remarks *</label>
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
						<button type="button" class="btn btn-danger" id="btnFail">FAIL</button>
						<button type="button" class="btn btn-primary" id="btnPass">PASS</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to fail this applicant?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/admin/transaction/assessinterview.js"></script>
@endsection