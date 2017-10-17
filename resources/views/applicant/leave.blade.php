@extends('applicant.templates.default')

@section('content')
@if (Auth::user()->applicant->status == 10)
	<section class="content-header">
		<h1>Leave</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button class="btn btn-primary btn-md" id="btnNewLeave">New Leave</button><hr>
						<table id="tblRequestLeave" class="table table-striped table-bordered">
							<thead>
								<th>Date Issued</th>
								<th>Date Range</th>
								<td>Reason</td>
								<td style="text-align: center;">Status</td>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="leave-list">
								@foreach ($leaverequests as $leaverequest)
									<tr id="id{{$leaverequest->leaverequestid}}">
										<td>{{$leaverequest->request->datecreated->format('Y-m-d')}}</td>
										<td>{{$leaverequest->start->format('F d, Y')}} - {{$leaverequest->end->format('F d, Y')}}</td>
										<td>{{$leaverequest->reason}}</td>
										@if ($leaverequest->request->status == 0)
											<td style="text-align: center;">PENDING</td>
											<td style="text-align: center;">
												<button class="btn btn-danger btn-xs" id="btnCancel" value="{{$leaverequest->leaverequestid}}">Cancel</button>
											</td>
										@elseif ($leaverequest->request->status == 1)
											<td style="text-align: center;">APPROVED</td>
											<td></td>
										@else
											<td style="text-align: center;">DECLINED</td>
											<td></td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" id="contractstartdate" name="contractstartdate" value="{{Auth::user()->applicant->qualificationcheck->deploymentsite->contract->startdate}}">
			<input type="hidden" id="contractenddate" name="contractenddate" value="{{Auth::user()->applicant->qualificationcheck->deploymentsite->contract->expiration}}">
		</div>
	</section>

	<div class="modal fade" id="modalRequestLeave">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRequestLeave" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Request Leave</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Date Range *</label>
							<input type="text" class="form-control" id="daterange" required>
						</div>
						<div class="form-group">
							<label>Reason *</label>
							<textarea class="form-control" rows="3" id="reason" required></textarea>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveRequestLeave">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalCancelRequest">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to cancel this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnConfirmCancel">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
@endif
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/applicant/leave.js"></script>
@endsection