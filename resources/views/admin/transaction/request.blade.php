@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Requests</h1>
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
										<td>{{$request->account->client->contactperson}}</td>
									@else
										<td>{{$request->account->manager->lastname}}, {{$request->account->manager->firstname}} {{$request->account->manager->middlename}}</td>
									@endif
									<td>{{$request->datecreated->format('Y-m-d')}}</td>
									@if ($request->status == 0)
										<td style="text-align: center;">DEPLOY</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnDeploy" value="{{$request->requestid}}">Deploy</button>
											<button class="btn btn-danger btn-xs" id="btnDecline" value="{{$request->requestid}}">Decline</button>
										</td>
									@elseif ($request->status == 1)
										<td style="text-align: center;">PENDING RECEIVE</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnUpdate" value="{{$request->requestid}}">Update</button>
										</td>
									@elseif ($request->status == 2)
										<td style="text-align: center;">ITEMS RECEIVED</td>
										<td></td>
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
						<h3>Requested Item</h3>
						<table id="tblRequestItem" class="table table-striped table-bordered">
							<thead>
								<th>Item Name</th>
								<th>Item Type</th>
								<th>Approx Quantity</th>
							</thead>
							<tbody id="requestitem-list"></tbody>
						</table><hr>
						<h3>Inventory</h3>
						<table id="tblInventory" class="table table-striped table-bordered">
							<thead>
								<th>Item Name</th>
								<th>Item Type</th>
								<th style="text-align: center;">Quantity Available</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="inventory-list"></tbody>
						</table><hr>
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
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button id="btnItemSave" class="btn btn-primary">SAVE</button>
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
					<table id="tblFirearm" class="table table-striped table-bordered">
						<thead>
							<th>License</th>
							<th>Expiration</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="firearm-list"></tbody>
					</table><hr>
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
				<div class="modal-footer">
					<button class="btn btn-primary" id="btnFirearmSave">SAVE</button>
	        		<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
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

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/request.js"></script>
@endsection