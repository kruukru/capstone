@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Schedule</h1>
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
											<td></td>
										@else
											<td style="text-align: center;">N/A</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnManage" value="{{$applicant->applicantid}}">Manage</button>
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

	<div class="modal fade" id="modalSchedule">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formSchedule" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Manage Schedule</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="row">
							<div class="form-group">
								<div class="col-md-2">
									<label>Sunday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="sundaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="sundaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Monday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="mondaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="mondaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Tuesday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="tuesdaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="tuesdaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Wednesday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="wednesdaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="wednesdaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Thursday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="thursdaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="thursdaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Friday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="fridaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="fridaytimeout">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-2">
									<label>Saturday</label>									
								</div>
								<div class="col-md-5">
									<label>Time IN</label>
									<input type="text" class="form-control" id="saturdaytimein">
								</div>
								<div class="col-md-5">
									<label>Time OUT</label>
									<input type="text" class="form-control" id="saturdaytimeout">
								</div>
							</div>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveSchedule">SAVE</button>
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
	<script src="/js/custom/client/schedule.js"></script>
@endsection