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
						@if (Auth::user()->applicant->status == 0)
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
						@elseif (Auth::user()->applicant->status == 1 || Auth::user()->applicant->status == 5)
							<div class="wizard">
					            <div class="wizard-inner">
					                <div class="connecting-line"></div>
					                <ul class="nav nav-tabs" role="tablist">

					                	<li role="presentation" class="active" id="1">
					                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="STEP 1">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-list-alt"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="2">
					                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="STEP 2">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-list"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="3">
					                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="STEP 3">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-user"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="4">
					                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="STEP 4">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-tag"></i>
					                            </span>
					                        </a>
					                    </li>
					                </ul>
					            </div>
				                <div class="tab-content">
				                	<div class="tab-pane active" role="tabpanel" id="step1">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 1:</h2>
						                        <h4>Please proceed to the testing phase</h4>
											</div>
										</div>
				                    </div>
				                </div>
					        </div>
					    @elseif (Auth::user()->applicant->status == 2 || Auth::user()->applicant->status == 6)
							<div class="wizard">
					            <div class="wizard-inner">
					                <div class="connecting-line"></div>
					                <ul class="nav nav-tabs" role="tablist">

					                	<li role="presentation" id="1">
					                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="STEP 1">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="active" id="2">
					                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="STEP 2">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-list"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="3">
					                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="STEP 3">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-user"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="4">
					                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="STEP 4">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-tag"></i>
					                            </span>
					                        </a>
					                    </li>
					                </ul>
					            </div>
				                <div class="tab-content">
				                	<div class="tab-pane" role="tabpanel" id="step1">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 1:</h2>
						                        <h4>Please proceed to the testing phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane active" role="tabpanel" id="step2">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 2:</h2>
						                        <h4>Please proceed to the test assessment phase</h4>
											</div>
										</div>
				                    </div>
				                </div>
					        </div>
					    @elseif (Auth::user()->applicant->status == 3 || Auth::user()->applicant->status == 7)
							<div class="wizard">
					            <div class="wizard-inner">
					                <div class="connecting-line"></div>
					                <ul class="nav nav-tabs" role="tablist">

					                	<li role="presentation" id="1">
					                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="STEP 1">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" id="2">
					                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="STEP 2">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="active" id="3">
					                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="STEP 3">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-user"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="disabled" id="4">
					                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="STEP 4">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-tag"></i>
					                            </span>
					                        </a>
					                    </li>
					                </ul>
					            </div>
				                <div class="tab-content">
				                	<div class="tab-pane" role="tabpanel" id="step1">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 1:</h2>
						                        <h4>Please proceed to the testing phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane" role="tabpanel" id="step2">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 2:</h2>
						                        <h4>Please proceed to the test assessment phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane active" role="tabpanel" id="step3">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 3:</h2>
						                        <h4>Please proceed to the interview phase</h4>
											</div>
										</div>
				                    </div>
				                </div>
					        </div>
					    @elseif (Auth::user()->applicant->status == 4 || Auth::user()->applicant->status == 8)
							<div class="wizard">
					            <div class="wizard-inner">
					                <div class="connecting-line"></div>
					                <ul class="nav nav-tabs" role="tablist">

					                	<li role="presentation" id="1">
					                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="STEP 1">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" id="2">
					                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="STEP 2">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" id="3">
					                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="STEP 3">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-ok"></i>
					                            </span>
					                        </a>
					                    </li>

					                    <li role="presentation" class="active" id="4">
					                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="STEP 4">
					                            <span class="round-tab">
					                                <i class="glyphicon glyphicon-tag"></i>
					                            </span>
					                        </a>
					                    </li>
					                </ul>
					            </div>
				                <div class="tab-content">
				                	<div class="tab-pane" role="tabpanel" id="step1">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 1:</h2>
						                        <h4>Please proceed to the testing phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane" role="tabpanel" id="step2">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 2:</h2>
						                        <h4>Please proceed to the test assessment phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane" role="tabpanel" id="step3">
				                    	<div class="box box-primary">
				                    		<div class="box-body table-responsive">
						                        <h2>STEP 3:</h2>
						                        <h4>Please proceed to the interview phase</h4>
											</div>
										</div>
				                    </div>
				                    <div class="tab-pane active" role="tabpanel" id="step4">
				                        <div class="box box-primary">
				                    		<div class="box-body table-responsive">
				                    			@if (Auth::user()->applicant->status == 4)
				                    				<h2>STEP 4:</h2>
				                    				<h4>Please settle company requirements</h4>
				                    				<ul>
				                    					@foreach ($applicantrequirements as $applicantrequirement)
				                    						<li>{{$applicantrequirement->requirement->name}}</li>
				                    					@endforeach
				                    				</ul>
				                    			@elseif (Auth::user()->applicant->status == 8)
				                    				<h2>YOU ARE DONE</h2>
				                    			@endif
					                        </div>
										</div>
				                    </div>
				                </div>
					        </div>
					    @elseif (Auth::user()->applicant->status == 125)
					    	<h3>YOU FAILED</h3>
					    	<h5>You cannot make an appointment temporarily until {{Auth::user()->applicant->updated_at->addMonths(3)->format('M. d, Y')}}.</h5>
					    @else
					    	<h3>{{$company->name}}</h3>
					    	<h4>{{$company->address}}</h4>
					    	<h4>{{$company->contactno}}</h4>
					    	<h4>Email: {{$company->email}}</h4>
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

@section('css')
	<link rel="stylesheet" type="text/css" href="/css/custom/applicant/appointment.css">
@endsection

@section('script')
	<script src="/js/custom/applicant/appointment.js"></script>
@endsection