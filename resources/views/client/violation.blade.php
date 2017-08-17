@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Violation</h1>
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
								<th>License Number</th>
								<th>Security Guard Name</th>
								<th>Total Violation</th>
								<th style="float: right; padding-right: 5px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>31954193</td>
								<td>Vayne, Shaun</td>
								<td>1</td>
								<td style="float: right;"><button class="btn btn-primary btn-xs" id="btnView" value="test">View</button></td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for update client -->
	<div class="modal fade" id="modalViolation">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formViolation" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Violation</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<h3>List of Violation</h3>
						<table class="table table-striped">
							<thead>
								<th>Violation</th>
								<th>Severity</th>
							</thead>
							<tbody id="deploy-list">
								<tr>
									<td>Sleeping while on duty</td>
									<td>Major Offense</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<h3>New Violation</h3>
						<div class="form-group">
							<label>Violation</label>
							<select class="form-control">
								<option>Sleeping while on duty</option>
								<option>Incomplete uniform</option>
							</select>
						</div>
						<div class="form-group">
							<label>Reason</label>
							<textarea class="form-control" cols="3"></textarea>						
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
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/client/violation.js"></script>
@endsection