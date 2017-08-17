@extends('applicant.templates.default')

@section('content')
	<section class="content-header">
		<h1>Appointment</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						@if ($appointment == null)
							<div id="calendar"></div>
						@else
							<table class="table table-striped table-bordered">
								<thead>
									<th>Appointment No</th>
									<th>Date</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="appointment-list">
									<tr>
										<td>{{$appointment->appointmentid}}</td>
										<td>{{$appointment->appointmentdate->date->format('l, M. d, Y')}}</td>
										<td style="text-align: center;">
											<a href="{{ route('applicant-appointment-voucher') }}"><button class="btn btn-primary btn-xs">Voucher</button></a>
											<button class="btn btn-danger btn-xs" id="btnCancel" value="{{$appointment->appointmentid}}">Cancel</button>
										</td>
									</tr>
								</tbody>
							</table>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modalAppointment">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body"></div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnConfirmAppointment">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalAppointmentRemove">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to cancel your appointment?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnConfirmAppointmentRemove">CONFIRM</button>
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
	<script src="/js/custom/applicant/appointment.js"></script>
@endsection