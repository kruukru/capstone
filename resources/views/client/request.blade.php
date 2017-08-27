@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Request</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button class="btn btn-primary btn-md" id="btnNewRequestItem">New Request Item</button>
						<button class="btn btn-primary btn-md" id="btnNewRequestSG">New Request Security Guard</button><hr>
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
									<td>{{$request->type}}</td>
									<td>{{$request->deploymentsite->sitename}}</td>
									<td>{{$request->deploymentsite->location}}</td>
									@if ($request->account->client)
										<td>{{$request->account->client->contactperson}}</td>
									@else
										<td>{{$request->account->manager->lastname}}, {{$request->account->manager->firstname}} {{$request->account->manager->middlename}}</td>
									@endif
									<td>{{$request->datecreated->format('Y-m-d')}}</td>
									@if ($request->deleted_at != null)
										<td style="text-align: center;">DECLINED</td>
										<td></td>
									@elseif ($request->status == 0)
										<td style="text-align: center;">PENDING</td>
										<td style="text-align: center;">
											<button class="btn btn-danger btn-xs" id="btnCancel" value="{{$request->requestid}}">Cancel</button>
										</td>
									@elseif ($request->status == 1)
										<td style="text-align: center;">ITEMS RECEIVE</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnItem" value="{{$request->requestid}}">Check</button>
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

	<!-- modal for cancel -->
	<div class="modal fade" id="modalCancelConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to cancel this request?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalRequestItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRequestItem" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>New Request Item</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Deployment Site *</label>
							<select id="deploymentsitelist" class="form-control" style="width: 100%" required></select>
						</div>
						<h3>Inventory</h3>
						<table id="tblInventory" class="table table-striped table-bordered">
							<thead>
								<th>Item Name</th>
								<th>Item Type</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="inventory-list"></tbody>
						</table><hr>
						<h3>Request Item</h3>
						<table id="tblRequestItem" class="table table-striped table-bordered">
							<thead>
								<th>Item Name</th>
								<th>Item Type</th>
								<th style="text-align: center;">Approx Quantity</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="requestitem-list"></tbody>
						</table>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnRequestItemSave">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalItem">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Item List</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<h3>Firearm</h3>
						<table id="tblFirearm" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>License</th>
								<th>Expiration</th>
							</thead>
							<tbody id="firearm-list"></tbody>
						</table>
					</div>
					<div class="form-group">
						<h3>Item</h3>
						<table id="tblItem" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>Item Type</th>
								<th>Quantity</th>
							</thead>
							<tbody id="item-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-danger" id="btnIncomplete">INCOMPLETE</button>
						<button type="button" class="btn btn-primary" id="btnReceive">RECEIVE</button>
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
	<script src="/js/custom/client/request.js"></script>
@endsection