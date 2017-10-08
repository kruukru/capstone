@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Request</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblRequest" class="table table-striped table-bordered">
							<thead>
								<th>Request No.</th>
								<th>Request Type</th>
								<th>Deployment Site</th>
								<th>Location</th>
								<th>Requested By</th>
								<th>Requested At</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="request-list">
								@foreach ($requests as $request)
								<tr id="id{{$request->requestid}}">
									<td>{{$request->requestid}}</td>
									<td id="requesttype">{{$request->type}}</td>
									<td>{{$request->deploymentsite->sitename}}</td>
									<td>{{$request->deploymentsite->location}}</td>
									@if ($request->account->client)
										<td>{{$request->account->client->lastname}}, {{$request->account->client->firstname}} {{$request->account->client->middlename}}</td>
									@else
										<td>{{$request->account->manager->lastname}}, {{$request->account->manager->firstname}} {{$request->account->manager->middlename}}</td>
									@endif
									<td>{{$request->datecreated->format('Y-m-d')}}</td>
									@if ($request->status == 0)
										<td style="text-align: center;">DEPLOY</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnDeploy" value="{{$request->requestid}}">Deploy</button>
											@if (!$request->deploy)
												<button class="btn btn-danger btn-xs" id="btnDecline" value="{{$request->requestid}}">Decline</button>
											@endif
										</td>
									@elseif ($request->status == 1)
										@if ($request->type == "ITEM")
											<td style="text-align: center;">PENDING RECEIVE</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateItem" value="{{$request->requestid}}">Update</button>
											</td>
										@elseif ($request->type == "PERSONNEL")
											<td style="text-align: center;">PENDING APPROVAL</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateSecurityGuard" value="{{$request->requestid}}">Update</button>
											</td>
										@endif
									@endif
								</tr>
								@endforeach
								@foreach ($replaceapplicants as $replaceapplicant)
								<tr id="idr{{$replaceapplicant->replaceapplicantid}}">
									<td>{{$replaceapplicant->replaceapplicantid}}</td>
									<td id="replaceapplicanttype">REPLACEMENT</td>
									<td>{{$replaceapplicant->qualificationcheck->deploymentsite->sitename}}</td>
									<td>{{$replaceapplicant->qualificationcheck->deploymentsite->location}}</td>
									@if ($replaceapplicant->account->client)
										<td>{{$replaceapplicant->account->client->lastname}}, {{$replaceapplicant->account->client->firstname}} {{$replaceapplicant->account->client->middlename}}</td>
									@else
										<td>{{$replaceapplicant->account->manager->lastname}}, {{$replaceapplicant->account->manager->firstname}} {{$replaceapplicant->account->manager->middlename}}</td>
									@endif
									<td>{{$replaceapplicant->created_at->format('Y-m-d')}}</td>
									<td style="text-align: center;">PENDING</td>
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnAssessReplace" value="{{$replaceapplicant->replaceapplicantid}}">Assess</button>
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

	<!-- modal for deploy security guard -->
	<div class="modal fade" id="modalSecurityGuard">
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
					</div><hr>
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
					</div><hr>
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
    					<button type="button" class="btn btn-primary" id="btnSaveSecurityGuard">SAVE</button>
    					<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for deploy item -->
	<div class="modal fade" id="modalItem">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<form id="formDeploy" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Deploy Item</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group table-responsive">
							<h3>Requested Item</h3>
							<table id="tblRequestItem" class="table table-striped table-bordered">
								<thead>
									<th>Item Name</th>
									<th>Item Type</th>
									<th>Approx Quantity</th>
								</thead>
								<tbody id="requestitem-list"></tbody>
							</table>
						</div><hr>
						<div class="form-group table-responsive">
							<h3>Inventory</h3>
							<table id="tblInventory" class="table table-striped table-bordered">
								<thead>
									<th>Item Name</th>
									<th>Item Type</th>
									<th style="text-align: center;">Quantity Available</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="inventory-list"></tbody>
							</table>
						</div><hr>
						<div class="form-group table-responsive">
							<h3>Deploy Item</h3>
							<table id="tblDeployItem" class="table table-striped table-bordered">
								<thead>
									<th>Item Name</th>
									<th>Item Type</th>
									<th style="text-align: center;">Quantity</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="deployitem-list"></tbody>
							</table>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveItem">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for firearm -->
	<div class="modal fade" id="modalFirearm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Firearm</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-9">
								<h3>Firearm Inventory</h3>
							</div>
							<div class="col-md-3">
								<h4 id="firearm-need">5 Firearm(s)</h4>
							</div>
						</div>
					</div>
					<div class="form-group table-responsive">
						<table id="tblFirearm" class="table table-striped table-bordered">
							<thead>
								<th>License</th>
								<th>Expiration</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="firearm-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive">
						<h3>Deploy Firearm</h3>
						<table id="tblDeployFirearm" class="table table-striped table-bordered">
							<thead>
								<th>License</th>
								<th>Expiration</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deployfirearm-list"></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="btnSaveFirearm">SAVE</button>
	        		<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalReplace">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Replace Security Guard</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="form-group">
							<label>Applicant need to be replace:</label>
							<h4 id="replaceapplicant"></h4>
						</div>
						<div class="form-group">
							<label>Reason:</label>
							<h4 id="reason"></h4>
						</div>
					</div>
					<div class="form-group table-responsive" id="divreplace" style="display: none;">
						<h3>Security Guard</h3>
						<table id="tblReplaceSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th style="text-align: center;">Vacant(day)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="replacesecurityguard-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnApproveReplace">REPLACE</button>
					<button type="button" class="btn btn-danger" id="btnDeclineReplace">DECLINE</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalReplaceConfirmation">
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
					<button type="button" class="btn btn-primary" id="btnReplaceConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalDeclineConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to decline this request?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnDeclineConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/admin/transaction/request.js"></script>
@endsection