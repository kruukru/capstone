@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Approved Request</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<!-- <a href="#"><button style="float: left;" id="btnNew" class="btn btn-primary btn-md">Deploy</button></a>
						<form id="formSearch" data-parsley-validate>
							<div class="input-group input-group-sm pull-right" style="width: 300px;">
								<input type="text" id="search" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" id="btnSearch"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</form> -->
						<table class="table table-striped">
							<thead>
								<th>Request Number</th>
								<th>Type</th>
								<th>Date Requested</th>
								<th style="float: right; padding-right: 10px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>3123</td>
								<td>Personnel Request</td>
								<td>2017-03-16</td>
								<td style="float: right;"><button class="btn btn-primary btn-xs" id="btnView" value="test">View</button></td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for update client -->
	<div class="modal fade" id="modalRequest">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRequest" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Request Details</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<h3>Qualification</h3>
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
							<button type="button" class="btn btn-primary" id="btnRestoreConfirm">Approve</button>
        					<button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
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
	<script src="/js/custom/client/approverequest.js"></script>
@endsection