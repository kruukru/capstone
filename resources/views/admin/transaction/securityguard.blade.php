@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Security Guard</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>License Number</th>
								<th>Expiration</th>
								<th>Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deploy-list">
								@foreach ($applicants as $applicant)
								<tr id="id{{$applicant->applicantid}}">
									<td>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
									<td>{{$applicant->license}}</td>
									<td>{{$applicant->licenseexpiration->format('M. d, Y')}}</td>
									@if ($applicant->status == 0)
										<td style="text-align: center;">FOR SUBMISSION</td>
									@elseif ($applicant->status == 1)
										<td style="text-align: center;">FOR TESTING</td>
									@elseif ($applicant->status == 2)
										<td style="text-align: center;">FOR ASSESS TEST</td>
									@elseif ($applicant->status == 3)
										<td style="text-align: center;">FOR ASSESS INTERVIEW</td>
									@elseif ($applicant->status == 4)
										<td style="text-align: center;">FOR COMPLETION OF REQUIREMENT</td>
									@elseif ($applicant->status == 5)
										<td style="text-align: center;">FOR TESTING</td>
									@elseif ($applicant->status == 6)
										<td style="text-align: center;">FOR ASSESS TEST</td>
									@elseif ($applicant->status == 7)
										<td style="text-align: center;">FOR ASSESS INTERVIEW</td>
									@elseif ($applicant->status == 8)
										<td style="text-align: center;">POOLING</td>
									@elseif ($applicant->status == 9)
										<td style="text-align: center;">PENDING</td>
									@elseif ($applicant->status == 10)
										<td style="text-align: center;">DEPLOYED</td>
									@elseif ($applicant->status == 125)
										<td style="text-align: center;">FAILED</td>
									@endif
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs">View Profile</button>
										<button class="btn btn-primary btn-xs" id="btnDeploy" value="test">Remove</button>
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
	<script src="/js/custom/admin/transaction/securityguard.js"></script>
@endsection