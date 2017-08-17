@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Submit Credential</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblApplicant" class="table table-striped table-bordered">
							<thead>
								<th>Applicant No.</th>
								<th>Name</th>
								<th>Appointment No.</th>
								<th>Date</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="applicant-list">
								@foreach ($applicants as $applicant)
								<tr id="id{{$applicant->applicantid}}">
									<td>{{$applicant->applicantid}}</td>
									<td>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
									<td>{{$applicant->appointment->appointmentid}}</td>
									<td>{{$applicant->appointment->appointmentdate->date->format('l, M. d, Y')}}</td>
									@if ($applicant->status == 0)
										<td style="text-align: center;">FOR SUBMISSION</td>
									@else
										<td style="text-align: center;">FOR FOLLOW UP</td>
									@endif
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnAssess" value="{{$applicant->applicantid}}">Assess</button>
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

	<div class="modal fade" id="modalCredential">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Assess Credentials</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label>Applicant Name:</label>
						<h3 id="applicantName">Name</h3>
					</div>
					<hr>
					<h3>LIST OF REQUIREMENTS</h3>
					<div class="form-group">
						<table id="tblRequirement" class="table table-striped table-bordered">
							<thead>
								<th>Credentials</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="requirement-list"></tbody>
						</table>
					</div>
					<hr>
					<h3>PASSED</h3>
					<div class="form-group">
						<table id="tblPass" class="table table-striped table-bordered">
							<thead>
								<th>Credentials</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="pass-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/submitcredential.js"></script>
@endsection