@extends(Auth::user()->accounttype == 10 ? 'client.templates.default' : 'manager.templates.default')

@section('content')
	<section class="content-header">
		<h1>Security Guard</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th>Deployment Site</th>
								<th>Location</th>
								<th>Schedule</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="securityguard-list">
								@foreach ($applicants as $applicant)
									<tr id="id{{$applicant->applicantid}}">
										<td>{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}</td>
										<td>{{$applicant->qualificationcheck->deploymentsite->sitename}}</td>
										<td>{{$applicant->qualificationcheck->deploymentsite->location}}</td>
										@if ($applicant->schedule)
											<td>
												<ul>
													@if ($applicant->schedule->sunday)
														<li>SUNDAY: {{$applicant->schedule->sundayin}} - {{$applicant->schedule->sundayout}}</li>
													@endif
													@if ($applicant->schedule->monday)
														<li>MONDAY: {{$applicant->schedule->mondayin}} - {{$applicant->schedule->mondayout}}</li>
													@endif
													@if ($applicant->schedule->tuesday)
														<li>TUESDAY: {{$applicant->schedule->tuesdayin}} - {{$applicant->schedule->tuesdayout}}</li>
													@endif
													@if ($applicant->schedule->wednesday)
														<li>WEDNESDAY: {{$applicant->schedule->wednesdayin}} - {{$applicant->schedule->wednesdayout}}</li>
													@endif
													@if ($applicant->schedule->thursday)
														<li>THURSDAY: {{$applicant->schedule->thursdayin}} - {{$applicant->schedule->thursdayout}}</li>
													@endif
													@if ($applicant->schedule->friday)
														<li>FRIDAY: {{$applicant->schedule->fridayin}} - {{$applicant->schedule->fridayout}}</li>
													@endif
													@if ($applicant->schedule->saturday)
														<li>SATURDAY: {{$applicant->schedule->saturdayin}} - {{$applicant->schedule->saturdayout}}</li>
													@endif
												</ul>
											</td>
										@else
											<td style="text-align: center;">N/A</td>
										@endif
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnProfile" value="{{$applicant->applicantid}}">View Profile</button>
											@if ($applicant->qualificationcheck->replaceapplicant)
												<button class="btn btn-warning btn-xs" id="btnCancelReplace" value="{{$applicant->applicantid}}">Cancel Replacement</button>
											@else
												<button class="btn btn-primary btn-xs" id="btnReplace" value="{{$applicant->applicantid}}">Replace SG</button>
											@endif
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

	<div class="modal fade" id="modalProfile">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Profile</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<img id="pictureview" src="/applicant/default.png" alt="IMAGE" style="width: 35%; height: 35%;" class="center-block">
					</div>
					<div class="form-group table-responsive">
						<h3>Applicant Info</h3>
						<table class="table table-striped table-bordered">
							<tbody id="applicantinfo-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Education Background</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Graduate Type</th>
								<th>Degree</th>
								<th>Date Graduated</th>
								<th>School Graduated</th>
							</thead>
							<tbody id="education-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Employment Record</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Company</th>
								<th>Industry Type</th>
								<th>Duration (months)</th>
								<th>Reason For Leaving</th>
							</thead>
							<tbody id="employment-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Training Certificate</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Certificate</th>
								<th>Conducted By</th>
								<th>Date Conducted</th>
							</thead>
							<tbody id="training-list"></tbody>
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

	<div class="modal fade" id="modalReplace">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formReplace" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Replace Security Guard</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Security Guard Name:</label>
							<h4 id="securityGuardName"></h4>
						</div><hr>
						<div class="form-group">
							<label>Reason for Replacement <span class="asterisk-red">*</span></label>
							<textarea class="form-control" rows="3" id="reason" required></textarea>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveReplace">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/client/securityguard.js"></script>
@endsection