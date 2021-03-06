@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Deploy Security Guard</h1>
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
							<tbody id="deploy-list">
								@foreach ($deploymentsites as $deploymentsite)
									<tr id="id{{$deploymentsite->deploymentsiteid}}">
										<td>{{$deploymentsite->sitename}}</td>
										<td>{{$deploymentsite->location}}, {{$deploymentsite->city}}, {{$deploymentsite->province}}</td>
										@if ($deploymentsite->status == 1)
											<td style="text-align: center;">QUALIFICATION RECEIVED</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnDeploy" value="{{$deploymentsite->deploymentsiteid}}">Deploy</button>
											</td>
										@elseif ($deploymentsite->status == 2)
											<td style="text-align: center;">PENDING APPROVAL</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateDeploy" value="{{$deploymentsite->deploymentsiteid}}">Update</button>
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

	<!-- modal for deploy sg -->
	<div class="modal fade" id="modalDeploy">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Deploy Security Guard</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<h3>Client Qualification</h3>
							</div>
							<div class="col-md-2 col-md-offset-4">
								<label>Client Qualification #</label>
								<select class="form-control" id="clientqualification-number"></select>
							</div>
						</div>
					</div>
					<div class="form-group table-responsive">
						<table id="tblQualification" class="table table-striped table-bordered">
							<thead>
								<th>Type</th>
								<th>Qualification</th>
							</thead>
							<tbody id="clientqualification-list"></tbody>
						</table>
					</div>
					<hr>
					<div class="form-group table-responsive">
						<table id="legend">
							<tr>
								<td style="padding-right: 20px;"><b>LEGEND:</b></td>
								<td class="leg grn"></td>
								<td id="legName">FULLY QUALIFIED</td>
								<td class="leg red"></td>
								<td id="legName">LESS QUALIFIED</td>
							</tr>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Pool</h3>
						<table id="tblPool" class="table table-bordered table-striped">
							<thead>
								<th>No.</th>
								<th style="min-width: 200px;">Name</th>
								<th>Gender</th>
								<th>Civil Status</th>
								<th>Attainment</th>
								<th style="text-align: center;">Work Exp(month)</th>
								<th style="text-align: center;">Age</th>
								<th style="text-align: center;">Height</th>
								<th style="text-align: center;">Weight</th>
								<th style="text-align: center;">Approx Distance(km)</th>
								<th style="text-align: center;">Vacant(day)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="pool-list"></tbody>
						</table>
					</div>
					<hr>
					<div class="form-group table-responsive">
						<h3>Deploy Security Guard</h3>
						<table id="tblDeploy" class="table table-striped table-bordered">
							<thead>
								<th>No.</th>
								<th style="min-width: 200px;">Name</th>
								<th>Gender</th>
								<th>Civil Status</th>
								<th>Attainment</th>
								<th style="text-align: center;">Work Exp(month)</th>
								<th style="text-align: center;">Age</th>
								<th style="text-align: center;">Height</th>
								<th style="text-align: center;">Weight</th>
								<th style="text-align: center;">Approx Distance(km)</th>
								<th style="text-align: center;">Vacant(day)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deployed-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
    					<button type="button" class="btn btn-primary" id="btnDeploySave">SAVE</button>
    					<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
	<style type="text/css">
		.posi {
			font-weight: bolder;
			color: green;
		}
		.nega {
			font-weight: bolder;
			color: red;
		}
		#legend {
			padding: 10px;
			margin-top: 10px;
		}
		.leg {
			min-width: 30px;
		}
		.red {
			background-color: #ffbdbd;
		}
		.blue {
			background-color: #a9daff;
		}
		.grn {
			background-color: #b0f7be;
		}
		.yllw {
			background-color: #fffca9;
		}
		.orng {
			background-color: #ffeeba;
		}
		#legName {
			padding:5px 25px 5px 10px;
		}
	</style>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/deploysecurityguard.js"></script>
@endsection