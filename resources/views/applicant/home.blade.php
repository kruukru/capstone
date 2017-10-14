@extends('applicant.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title">DEPLOYMENT SITE DETAILS</h3>
    			</div>
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Deployment Site:</label>
									<h4 id="sitename">{{Auth::user()->applicant->qualificationcheck ? Auth::user()->applicant->qualificationcheck->deploymentsite->sitename : "N/A"}}</h4>
								</div>
								<div class="form-group">
									<label>Location:</label>
									<h4 id="location">{{Auth::user()->applicant->qualificationcheck ? Auth::user()->applicant->qualificationcheck->deploymentsite->location : "N/A"}}</h4>
								</div>
								<div class="form-group">
									<label>Start Date:</label>
									<h4 id="startdate">{{Auth::user()->applicant->qualificationcheck ? Auth::user()->applicant->qualificationcheck->deploymentsite->contract->startdate->format('F d, Y') : "N/A"}}</h4>
								</div>
								<div class="form-group">
									<label>End Date:</label>
									<h4 id="enddate">{{Auth::user()->applicant->qualificationcheck ? Auth::user()->applicant->qualificationcheck->deploymentsite->contract->expiration->format('F d, Y') : "N/A"}}</h4>
								</div>
							</div>
							<div class="col-md-6">
								<label>Schedule:</label>
								@if (Auth::user()->applicant->schedule)
									<ul>
										@if (Auth::user()->applicant->schedule->sunday)
											<li><h4>SUNDAY: {{Auth::user()->applicant->schedule->sundayin}} - {{Auth::user()->applicant->schedule->sundayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->monday)
											<li><h4>MONDAY: {{Auth::user()->applicant->schedule->mondayin}} - {{Auth::user()->applicant->schedule->mondayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->tuesday)
											<li><h4>TUESDAY: {{Auth::user()->applicant->schedule->tuesdayin}} - {{Auth::user()->applicant->schedule->tuesdayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->wednesday)
											<li><h4>WEDNESDAY: {{Auth::user()->applicant->schedule->wednesdayin}} - {{Auth::user()->applicant->schedule->wednesdayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->thursday)
											<li><h4>THURSDAY: {{Auth::user()->applicant->schedule->thursdayin}} - {{Auth::user()->applicant->schedule->thursdayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->friday)
											<li><h4>FRIDAY: {{Auth::user()->applicant->schedule->fridayin}} - {{Auth::user()->applicant->schedule->fridayout}}</h4></li>
										@endif
										@if (Auth::user()->applicant->schedule->saturday)
											<li><h4>SATURDAY: {{Auth::user()->applicant->schedule->saturdayin}} - {{Auth::user()->applicant->schedule->saturdayout}}</h4></li>
										@endif
									</ul>
								@else
									<h4>N/A</h4>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title">LIST OF RECEIVED MEMORANDUMS</h3>
    			</div>
				<div class="box-body">
					<div class="form-group table-responsive">
						<table id="tblMemorandum" class="table table-striped table-bordered">
							<thead>
								<th>Subject</th>
								<th>Place Happen</th>
								<th>Detail</th>
								<th>Date Issued</th>
							</thead>
							<tbody>
								@foreach ($memorandums as $memorandum)
								<tr>
									<td>{{$memorandum->report->subject}}</td>
									<td>{{$memorandum->report->placehappen}}</td>
									<td>{{$memorandum->report->detail}}</td>
									<td>{{$memorandum->report->date->format('F d, Y')}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title">MOST RECENT LEAVE</h3>
    			</div>
				<div class="box-body">
					<div class="form-group">
						<div class="form-group">
							<label>Date Range:</label>
							<h4>{{Auth::user()->applicant->leaverequest->start->format('F d, Y')}} - {{Auth::user()->applicant->leaverequest->end->format('F d, Y')}}</h4>
							<h4>{{$leaverequest ? $leaverequest->start->format('F d, Y')}} - {{$leaverequest ? $leaverequest->end->format('F d, Y')}}</h4>
						</div>
						<div class="form-group">
							<label>Reason:</label>
							<h4>{{Auth::user()->applicant->leaverequest->reason}}</h4>
						</div>
						<div class="form-group">
							<label>Status:</label>
							<h4>{{Auth::user()->applicant->leaverequest->request->status == 0 ? "PENDING" : "APPROVED"}}</h4>
						</div>
						<div class="form-group">
							<button class="btn btn-default pull-right" id="btnCancelRequestLeave">CANCEL LEAVE</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/applicant/dashboard.js"></script>
@endsection