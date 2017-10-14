@extends(Auth::user()->accounttype == 10 ? 'client.templates.default' : 'manager.templates.default')

@section('content')
	<section class="content-header">
		<h1>Attendance</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblDeploymentSite" class="table table-striped table-bordered">
							<thead>
								<th>Deployment Site</th>
								<th>Address</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deploymentsite-list">
								@foreach ($deploymentsites as $deploymentsite)
									<tr id="id{{$deploymentsite->deploymentsiteid}}">
										<td>{{$deploymentsite->sitename}}</td>
										<td>{{$deploymentsite->location}} {{$deploymentsite->city}} {{$deploymentsite->province}}</td>
										<td style="text-align: center;">ACTIVE</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnAttendance" value="{{$deploymentsite->deploymentsiteid}}">Attendance</button>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="container col-sm-12" style="display: none;" id="divCalendar">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title" id="deploymentsitename"></h3>
					</div>
					<div class="box-body table-responsive">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modalAttendance">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Attendance</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label>Date:</label>
						<h4 id="lbldate"></h4>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Security Guard</h3>
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th style="min-width: 200px;">Name</th>
								<th style="text-align: center;">Schedule</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="securityguard-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive" id="divattendance">
						<h3>Attendance</h3>
						<table id="tblAttendance" class="table table-striped table-bordered">
							<thead>
								<th style="min-width: 200px;">Name</th>
								<th style="text-align: center;">Time-IN</th>
								<th style="text-align: center;">Time-OUT</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="attendance-list"></tbody>
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

	<div class="modal fade" id="modalTime">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formTime" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Time IN / Time OUT</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
	            		<div class="form-group">
	            			<div class="row">
	            				<div class="col-md-6">
	            					<label>Time IN:</label>
	            					<input type="text" class="form-control" id="timein" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$">
	            				</div>
	            				<div class="col-md-6">
	            					<label>Time OUT:</label>
	            					<input type="text" class="form-control" id="timeout" pattern="^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$">
	            				</div>
	            			</div>
	            		</div>
	            		<div class="form-group">
	            			<label><input type="checkbox" name="cbstatus" id="cblate" value="late"> Late</label>&emsp;
	            			<label><input type="checkbox" name="cbstatus" id="cbabsent" value="absent"> Absent</label>
	            		</div>
	            		<div class="form-group" style="display: none;" id="divreason">
	            			<label>Reason</span></label>
	            			<textarea class="form-control" rows="3" id="reason"></textarea>
	            		</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="btnSaveTime">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/client/attendance.js"></script>
@endsection