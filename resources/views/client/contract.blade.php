@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Contract</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<!-- <a href="#"><button style="float: left;" id="btnPersonnelRequest" class="btn btn-primary btn-md">Add Personnel</button></a>   -->
						<!-- <form id="formSearch" data-parsley-validate>
							<div class="input-group input-group-sm pull-right" style="width: 300px;">
								<input type="text" id="search" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" id="btnSearch"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</form> -->
						<table class="table table-striped">
							<thead>
								<th>Contract Number</th>
								<th>Expiration</th>
								<th>Site Name</th>
								<th>Location</th>
								<th>Status</th>
							</thead>
							<tbody id="deploy-list">
								<td>312</td>
								<td>2017-10-10</td>
								<td>Andoks</td>
								<td>Tutuban Center</td>
								<td>Active</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modalDeploymentSite">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formPersonnel" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Deployment Site</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" id="btnSubmit" class="btn btn-success btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalRestock">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRestock" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Request Restock</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" id="btnSubmit" class="btn btn-success btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalRepair">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRepair" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Request Repair</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<h3>Item</h3>
						<table class="table table-striped">
							<thead>
								<th>Name</th>
								<th>Type</th>
								<th>Quantity</th>
								<th style="float: right; padding-right: 20px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>Glock</td>
								<td>Firearm</td>
								<td>4</td>
								<td style="float: right;">
									<input type="number" placeholder="Qty" style="width: 50px;">
									<button class="btn btn-primary btn-xs" id="btnView" value="test">Repair</button>
								</td>
							</tbody>
						</table>
						<hr>
						<h3>Repair</h3>
						<table class="table table-striped">
							<thead>
								<th>Name</th>
								<th>Type</th>
								<th>Quantity</th>
								<th style="float: right; padding-right: 20px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>Flashlight</td>
								<td>Equipment</td>
								<td>4</td>
								<td style="float: right;">
									<button class="btn btn-primary btn-xs" id="btnView" value="test">Remove</button>
								</td>
							</tbody>
						</table>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" id="btnSubmit" class="btn btn-success btn-block">
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
	<script src="/js/custom/client/deploymentsite.js"></script>
@endsection