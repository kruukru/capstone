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
						<table id="tblRequirement" class="table table-striped table-bordered">
							<thead>
								<th>Applicant Requirement</th>
								<th>Description</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="leave-list">

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
@endif
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/applicant/leave.js"></script>
@endsection