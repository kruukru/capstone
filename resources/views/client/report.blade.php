@extends(Auth::user()->accounttype == 10 ? 'client.templates.default' : 'manager.templates.default')

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
								<th>Subject</th>
								<th>Place Happened</th>
								<th>Details</th>
								<th>Person(s) Involved</th>
								<th>Issued By</th>
								<th>Date Issued</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="report-list">
								@foreach ($reports as $report)
								<tr id="id{{$report->reportid}}">
									<td>{{$report->violationid == null ? $report->commend->name : $report->violation->name}}</td>
									<td>{{$report->subject}}</td>
									<td>{{$report->placehappen}}</td>
									<td>{{$report->detail}}</td>
									<td><ul>
										@foreach ($report->personinvolve as $person)
											<li>{{$person->applicant->firstname}} {{$person->applicant->middlename}} {{$person->applicant->lastname}}</li>
										@endforeach
									</ul></td>
									@if ($report->account->client)
										<td>{{$report->account->client->lastname}}, {{$report->account->client->firstname}} {{$report->account->client->middlename}}</td>
									@else
										<td>{{$report->account->manager->lastname}}, {{$report->account->manager->firstname}} {{$report->account->manager->middlename}}</td>
									@endif
									<td>{{$report->date->format('Y-m-d')}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$report->reportid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$report->reportid}}">Remove</button>
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
							<label>Subject <span class="asterisk-red">*</span></label>
							<input type="text" class="form-control" id="subject" required>
						</div>
						<div class="form-group">
							<label>Place Happened <span class="asterisk-red">*</span></label>
							<input type="text" class="form-control" id="placehappen" required>
						</div>
						<div class="form-group">
							<label>Details <span class="asterisk-red">*</span></label>
							<textarea class="form-control" rows="3" id="detail" required></textarea>
						</div><hr>
						<div class="form-group table-responsive" id="divSecurityGuard">
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
						<div class="form-group table-responsive" id="divInvolveSecurityGuard">
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

	<!-- modal for remove -->
	<div class="modal fade" id="modalRemoveReport">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to remove this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
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