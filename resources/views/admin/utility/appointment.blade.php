@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Utility - Appointment</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Holiday</h3>
					</div>
					<div class="box-body table-responsive">
						<button id="btnNew" class="btn btn-primary btn-md">New Holiday</button><hr>
						<table id="tblHoliday" class="table table-striped table-bordered">
							<thead>
								<th>ID</th>
								<th>Name</th>
								<th>Date</th>
								<th style="text-align: center;">Yearly</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="holiday-list">
								@foreach ($holidays as $holiday)
								<tr id="id{{$holiday->holidayid}}">
									<td>{{$holiday->holidayid}}</td>
									<td>{{$holiday->name}}</td>
									@if ($holiday->yearly == 1)
										<td>{{$holiday->date->format('F d')}}</td>
										<td style="text-align: center;">YES</td>
									@else
										<td>{{$holiday->date->format('F d, Y')}}</td>
										<td style="text-align: center;">NO</td>
									@endif
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$holiday->holidayid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$holiday->holidayid}}">Remove</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="box box-primary">
					<form id="formAppointment" data-parsley-validate>
						<div class="box-header with-border">
							<h3 class="box-title">Appointment Day and Slot</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-1">
									<label><input type="checkbox" name="inputSunday" id="inputSunday" {{$appointmentslot->sunday == 1 ? 'checked': ''}}> Sunday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputMonday" id="inputMonday" {{$appointmentslot->monday == 1 ? 'checked': ''}}> Monday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputTuesday" id="inputTuesday" {{$appointmentslot->tuesday == 1 ? 'checked': ''}}> Tuesday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputWednesday" id="inputWednesday" {{$appointmentslot->wednesday == 1 ? 'checked': ''}}> Wednesday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputThursday" id="inputThursday" {{$appointmentslot->thursday == 1 ? 'checked': ''}}> Thursday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputFriday" id="inputFriday" {{$appointmentslot->friday == 1 ? 'checked': ''}}> Friday</label>
								</div>
								<div class="col-md-1">
									<label><input type="checkbox" name="inputSaturday" id="inputSaturday" {{$appointmentslot->saturday == 1 ? 'checked': ''}}> Saturday</label>
								</div>
								<div class="row">
									<div class="col-md-2">
										<label>Slot(s):</label>
										<input type="text" class="form-control" id="inputSlot" placeholder="# of slot(s)" maxlength="5" pattern="^[1-9][0-9]*$" value="{{$appointmentslot->slot}}" required>
									</div>
									<div class="col-md-3">
										<label>Create Appointment After:</label>
										<div class="input-group">
											<input type="text" class="form-control" id="inputDay" placeholder="# of day(s)" maxlength="3" pattern="^[1-9][0-9]*$" value="{{$appointmentslot->noofday}}" required>
											<span class="input-group-addon"><i>Day(s)</i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<button class="btn btn-primary pull-right" id="btnAppointmentSave">SAVE</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for new and update -->
	<div class="modal fade" id="modalHoliday">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formHoliday" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Name <span class="asterisk-red">*</span></label>
							<input type="text" id="inputHoliday" class="form-control" maxlength="100" required>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-9">
									<label>Date <span class="asterisk-red">*</span></label>
									<input type="text" class="form-control mydatepicker" id="inputHolidayDate" placeholder="yyyy-mm-dd" required>
								</div>
								<div class="col-md-3">
									<label><input type="checkbox" name="inputHolidayYearly" id="inputHolidayYearly"> Yearly</label>
								</div>
							</div>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSave" value="New">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalHolidayRemove">
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
					<button class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/utility/appointment.js"></script>
@endsection