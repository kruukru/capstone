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
								<th>Requested By</th>
								<th>Deployment Site</th>
								<th>Location</th>
								<th style="text-align: center;">Status</th>
							</thead>
							<tbody id="deploy-list">
								<td>1</td>
								<td>Item</td>
								<td>Jermaine</td>
								<td>5J Store Sta. Mesa</td>
								<td>Sta. Mesa Manila Metro Manila</td>
								<td style="text-align: center;">PENDING</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

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
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/client/request.js"></script>
@endsection