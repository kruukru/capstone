@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Report</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button class="btn btn-primary btn-md" id="btnNewCommendReport">New Commend Report</button>
						<button class="btn btn-primary btn-md" id="btnNewViolationReport">New Violation Report</button><hr>
						<table id="tblReport" class="table table-striped table-bordered">
							<thead>
								<th>Report Type</th>
								<th>Issued By</th>
								<th>Issued Date</th>
								<th>Person(s) Involved</th>
								<th style="text-align: center;">Status</th>
							</thead>
							<tbody id="report-list">
								<td>Commend</td>
								<td>Aug. 22, 2017</td>
								<td>Jermaine</td>
								<td>John Christopher Egos; Roy Tolentino</td>
								<td style="text-align: center;">
									<button class="btn btn-primary btn-xs">View</button>
								</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modalReport">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formReport" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>New Report</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<h4 id="modalTitle">REPORT TYPE: COMMEND</h4>
							<select class="form-control" id="reporttype" required></select>
						</div>
						<div class="form-group">
							<label>Place Happened *</label>
							<input type="text" class="form-control" id="placehappen" required>
						</div>
						<div class="form-group">
							<label>Subject *</label>
							<input type="text" class="form-control" id="subject" required>
						</div>
						<div class="form-group">
							<label>Details *</label>
							<textarea class="form-control" rows="3" id="detail"></textarea>
						</div><hr>
						<div class="form-group table-responsive">
							<h4>SECURITY GUARD</h4>
							<table id="tblSecurityGuard" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th>Deployment Site</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="securityguard-list"></tbody>
							</table>
						</div><hr>
						<div class="form-group table-responsive">
							<h4>PERSONNEL(S) INVOLVED</h4>
							<table id="tblInvolveSecurityGuard" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th>Deployment Site</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="involvesecurityguard-list"></tbody>
							</table>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveReport">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/client/report.js"></script>
@endsection