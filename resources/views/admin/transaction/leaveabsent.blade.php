@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Leave / Absent</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-header with-border">
        				<h3 class="box-title">LEAVE</h3>
        			</div>
					<div class="box-body table-responsive">
						<table id="tblLeave" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th>Date Issued</th>
								<th>Date Range</th>
								<th>Reason</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="leave-list">
								@foreach ($leaverequests as $leaverequest)
									<tr id="id{{$leaverequest->leaverequestid}}">
										<td>{{$leaverequest->applicant->firstname}} {{$leaverequest->applicant->middlename}} {{$leaverequest->applicant->lastname}}</td>
										<td>{{$leaverequest->request->datecreated->format('Y-m-d')}}</td>
										<td>{{$leaverequest->start->format('F d, Y')}} - {{$leaverequest->end->format('F d, Y')}}</td>
										<td>{{$leaverequest->reason}}</td>
										<td style="text-align: center;">
											@if ($leaverequest->request->status == 0)
												PENDING
											@elseif ($leaverequest->request->status == 1)
												APPROVED
											@elseif ($leaverequest->request->status == 2)
												DECLINED
											@endif
										</td>
										<td style="text-align: center;">
											@if ($leaverequest->request->status == 0)
												<button class="btn btn-primary btn-xs" id="btnAssess" value="{{$leaverequest->leaverequestid}}">Assess</button>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-header with-border">
        				<h3 class="box-title">ABSENT</h3>
        			</div>
					<div class="box-body table-responsive">
						<table id="tblAbsent" class="table table-striped table-bordered">
							<thead>
								<th>Applicant Name</th>
								<th>Deployment Site</th>
								<th>Location</th>
								<th>Date</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="absent-list">
								@foreach ($attendances as $attendance)
									<tr id="id{{$attendance->attendanceid}}">
										<td>{{$attendance->applicant->firstname}} {{$attendance->applicant->middlename}} {{$attendance->applicant->lastname}}</td>
										<td>{{$attendance->deploymentsite->sitename}}</td>
										<td>{{$attendance->deploymentsite->location}}</td>
										<td>{{$attendance->date->format('Y-m-d')}}</td>
										<td style="text-align: center;"> 
											<button class="btn btn-primary btn-xs" id="btnAssess" value="{{$attendance->attendanceid}}">Assess</button>
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

	<div class="modal fade" id="modalAssessAbsent">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Absent</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<img id="pictureview" src="/applicant/default.png" alt="IMAGE" style="width: 35%; height: 35%;" class="center-block">
					</div>
					<div class="form-group">
						<label>Security Guard Name:</label>
						<h4 id="securityguardname"></h4>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Security Guard</h3>
						<table id="tblAbsentReliever" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th style="text-align: center;">Vacant(day)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="absentreliever-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalAssessLeave">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Leave</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<img id="pictureview" src="/applicant/default.png" alt="IMAGE" style="width: 35%; height: 35%;" class="center-block">
					</div>
					<div class="form-group">
						<label>Security Guard Name:</label>
						<h4 id="securityguardname"></h4>
					</div>
					<div class="form-group">
						<label>Date Range:</label>
						<h4 id="daterange"></h4>
					</div>
					<div class="form-group">
						<label>Reason:</label>
						<h4 id="reason"></h4>
					</div>
					<div class="form-group table-responsive" id="divreliever" style="display: none;">
						<h3>Security Guard</h3>
						<table id="tblLeaveReliever" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th style="text-align: center;">Vacant(day)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="leavereliever-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button class="btn btn-primary" id="btnApproveLeave">APPROVE</button>
						<button class="btn btn-danger" id="btnDeclineLeave">DECLINE</button>
        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalLeaveRelieverConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to replace with this applicant?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnLeaveRelieverConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalAbsentRelieverConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to replace with this applicant?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnAbsentRelieverConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalDeclineLeave">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want decline this leave?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnDeclineLeaveConfirm">CONFIRM</button>
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
	<script src="/js/custom/admin/transaction/leaveabsent.js"></script>
@endsection