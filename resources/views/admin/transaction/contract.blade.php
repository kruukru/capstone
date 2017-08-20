@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Contract</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblContract" class="table table-striped table-bordered">
							<thead>
								<th>Contract No.</th>
								<th>Deployment Site</th>
								<th>Company Name</th>
								<th>Contact Person Name</th>
								<th>Contract Start Date</th>
								<th>Contract Expiration</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="contract-list">
								@foreach ($contracts as $contract)
								<tr id="id{{$contract->contractid}}">
									<td>{{$contract->contractid}}</td>
									<td>{{$contract->deploymentsite->sitename}}</td>
									<td>{{$contract->client->name}}</td>
									<td>{{$contract->client->contactperson}}</td>
									<td>{{$contract->startdate->format('M. d, Y')}}</td>
									<td>{{$contract->expiration->format('M. d, Y')}}</td>
									@if($contract->status == 0)
										<td style="text-align: center;">Active</td>
									@endif
									<td style="text-align: center;">
										<a href="{{ route('admin-contract-document', ['contractid' => $contract->contractid]) }}"><button class="btn btn-primary btn-xs">View</button></a>
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

	<!-- modal for new contract -->
	<div class="modal fade" id="modalContract">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formContract" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>New Contract</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<h3>Company Details</h3>
						<div id="companyDetails">
							<div class="form-group">
								<label>Name *</label>
								<input type="text" id="inputCompanyName" class="form-control" placeholder="Name" required>
							</div>
							<div class="form-group">
								<label>Address *</label>
								<input type="text" id="inputCompanyAddress" class="form-control" placeholder="Address" required>
							</div>
							<div class="form-group">
								<label>Contact No *</label>
								<input type="text" id="inputCompanyContactNo" class="form-control" placeholder="Contact No" pattern="\d+" required>
							</div>
							<div class="form-group">
								<label>Contact Person *</label>
								<input type="text" id="inputCompanyContactPerson" class="form-control" placeholder="Contact Person" required>
							</div>
							<div class="form-group">
								<label>Contact Person No *</label>
								<input type="text" id="inputCompanyContactPersonNo" class="form-control" placeholder="Contact Person No" pattern="\d+" required>
							</div>
							<div class="form-group">
								<label>Email *</label>
								<input type="email" id="inputCompanyEmail" class="form-control" placeholder="Email" required>
							</div>
							<hr>
						</div>
						<h3>Contract Details</h3>
						<div class="form-group">
							<label>Number of Security Guard to Hire *</label>
							<input type="text" id="inputNumberSecurityGuard" class="form-control" placeholder="# of Security Guard" pattern="\d+" required>
						</div>
						<div class="form-group">
							<label>Rate Type *</label>
							<select class="form-control" id="inputRateType" required></select>
						</div>
						<div class="form-group">
							<label>Contract Length(days) *</label>
							<input type="text" id="inputContractLength" class="form-control" placeholder="Contract Length" pattern="\d+" required>
						</div>
						<div class="form-group">
							<label>Price *</label>
							<input type="text" id="inputContractPrice" class="form-control" placeholder="Contract Price" pattern="([0-9]{1,6})(\.\d{1,2})?" required>
						</div>
						<div class="form-group">
							<label>Place Held *</label>
							<input type="text" id="inputPlaceHeld" class="form-control" placeholder="Place Held" required>
						</div>
						<div class="form-group">
							<label>Building/Area Name *</label>
							<input type="text" id="inputBuildingAreaName" class="form-control" placeholder="Building/Area Name" required>
						</div>
						<div class="form-group">
							<label>Address *</label>
							<input type="text" id="inputAddress" class="form-control" placeholder="Address" required>
						</div>
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

	<!-- modal for renew contract -->
	<div class="modal fade" id="modalRenewContract">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRenewContract" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Renew Contract</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Contract Length (days) *</label>
							<input type="text" id="inputContractRenewLength" class="form-control" placeholder="Contract Length" pattern="\d+" required>
						</div>
						<div class="form-group">
							<label>Price *</label>
							<input type="text" id="inputContractRenewPrice" class="form-control" placeholder="Contract Price" pattern="([0-9]{1,6})(\.\d{1,2})?" required>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" id="btnRenewSubmit" class="btn btn-success btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
	<meta name="AuthenticatedID" content="{{ Auth::user()->admin->adminid }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/contract.js"></script>
@endsection