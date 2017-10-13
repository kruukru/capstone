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
									<td>{{$contract->client->company}}</td>
									<td>{{$contract->client->lastname}}, {{$contract->client->firstname}} {{$contract->client->middlename}}</td>
									<td>{{$contract->startdate->format('M. d, Y')}}</td>
									<td>{{$contract->expiration->format('M. d, Y')}}</td>
									<td style="text-align: center;">
										@if ($contract->status == 0)
											ACTIVE
										@elseif ($contract->status == 1)
											EXPIRED
										@elseif ($contract->status == 2)
											TERMINATED
										@endif
									</td>
									<td style="text-align: center;">
										@if ($contract->status == 0)
											<a href="{{ route('admin-contract-document', ['contractid' => $contract->contractid]) }}"><button class="btn btn-primary btn-xs">View Contract</button></a>
											<button class="btn btn-success btn-xs" id="btnExtend" value="{{$contract->contractid}}">Extend</button>
											<button class="btn btn-danger btn-xs" id="btnTerminate" value="{{$contract->contractid}}">Terminate</button>
										@endif
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

	<div class="modal fade" id="modalExtendContract">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formExtendContract" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Extend Contract</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Length <span class="asterisk-red">*</span></label>
							<div class="row">
								<div class="col-md-12">
									<div class="column">
										<div class="col-md-9 no-padding">
											<input type="text" id="inputLength" class="form-control" placeholder="Length" style="text-align: right;" pattern="^[1-9][0-9]*$" maxlength="5" required>
										</div>
										<div class="col-md-3 no-padding">
											<select class="form-control" id="lengthtype">
												<option value="day">Day(s)</option>
												<option value="month">Month(s)</option>
												<option value="year">Year(s)</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveExtendContract">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalTerminateContract">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to terminate this contract?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnConfirmTerminate">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
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