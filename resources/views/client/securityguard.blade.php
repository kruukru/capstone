@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Security Guard</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table class="table table-striped">
							<thead>
								<th>License Number</th>
								<th>Security Guard Name</th>
								<th>Deployment Site</th>
								<th>Criteria Number</th>
								<th style="float: right; padding-right: 20px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>ABC20170123456</td>
								<td>Santos, Ben</td>
								<td>3R Barber Shop</td>
								<td>1</td>
								<td style="float: right;"><button class="btn btn-primary btn-xs" id="btnDeploy" value="test">Replace</button></td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modalPersonnel">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formPersonnel" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Request Personnel</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<h3>Criteria Number</h3>
						<table class="table table-striped">
							<thead>
								<th>Type</th>
								<th>Qualification</th>
							</thead>
							<tbody id="deploy-list">
								<tr>
									<td>Number of Security Guards</td>
									<td>10</td>
								</tr>
								<tr>
									<td>Gender</td>
									<td>Male</td>
								</tr>
								<tr>
									<td>Level of Attainment</td>
									<td>College</td>
								</tr>
								<tr>
									<td>Working Experience (months)</td>
									<td>3</td>
								</tr>
								<tr>
									<td>Marital Status</td>
									<td>Single</td>
								</tr>
								<tr>
									<td>Age</td>
									<td>20 - 30</td>
								</tr>
								<tr>
									<td>Height (cm)</td>
									<td>160 - 180</td>
								</tr>
								<tr>
									<td>Weight (kg)</td>
									<td>60 - 80</td>
								</tr>
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
	<script src="/js/custom/client/securityguard.js"></script>
@endsection