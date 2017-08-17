@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Deploy Item</h1>
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
										<td style="text-align: center;">DEPLOY ITEM</td>
										<td style="text-align: center;">
											<button class="btn btn-primary btn-xs" id="btnDeploy" value="{{$deploymentsite->deploymentsiteid}}">Deploy</button>
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

	<div class="modal fade" id="modalDeploy">
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
						<h3>Security Guard List</h3>
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
							</thead>
							<tbody id="securityguard-list"></tbody>
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
							<button id="btnSave" class="btn btn-primary">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

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
@endsection

@section('css')
	<style type="text/css">
		.modal {
			overflow-y: auto;
		}
	</style>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/deployitem.js"></script>
@endsection