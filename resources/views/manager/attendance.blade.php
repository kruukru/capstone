@extends('manager.templates.default')

@section('content')
	<section class="content-header">
		<h1>Deployment Site</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<table id="tblDeploymentSite" class="table table-striped table-bordered">
						<thead>
							<th>Site Name</th>
							<th>Location</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="deploymentsite-list">
							@foreach ($deploymentsites as $deploymentsite)
								<tr id="id{{$deploymentsite->deploymentsiteid}}">
									<td>{{$deploymentsite->sitename}}</td>
									<td>{{$deploymentsite->location}}</td>
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
		</div>
	</section>

	<!-- modal for attendance -->
	<div class="modal fade" id="modalAttendance">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Attendance</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<h3>SECURITY GUARD</h3>
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="securityguard-list"></tbody>
						</table>
					</div><hr>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button class="btn btn-primary" id="btnSave">SAVE</button>
        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/manager/attendance.js"></script>
@endsection