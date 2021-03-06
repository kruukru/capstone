@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - Violation</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New Violation</button><hr>
						<table id="tblViolation" class="table table-striped table-bordered">
							<thead>
								<th>Violation</th>
								<th>Severity</th>
								<th>Description</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="violation-list">
								@foreach ($violations as $violation)
								<tr id="id{{$violation->violationid}}">
									<td>{{$violation->name}}</td>
									<td>{{$violation->severity}}</td>
									<td>{{$violation->description}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$violation->violationid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$violation->violationid}}">Remove</button>
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

	<!-- modal for new and update -->
	<div class="modal fade" id="modalViolation">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formViolation" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Violation <span class="asterisk-red">*</span></label>
							<input type="text" id="inputViolation" class="form-control" maxlength="100" required>
						</div>
						<div class="form-group">
							<label>Severity <span class="asterisk-red">*</span></label>
							<select id="inputViolationSeverity" class="form-control">
								<option value="Minor Offense">Minor Offense</option>
								<option value="Major Offense">Major Offense</option>
								<option value="Grave Offense">Grave Offense</option>
							</select>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea id="inputViolationDescription" rows="3" class="form-control"></textarea>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button id="btnSave" value="New" class="btn btn-primary">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalViolationRemove">
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
	<script src="/js/custom/admin/maintenance/violation.js"></script>
@endsection