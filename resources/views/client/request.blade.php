@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Request</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button class="btn btn-primary btn-md" id="btnNewRequestSecurityGuard">New Request Security Guard</button>
						<button class="btn btn-primary btn-md" id="btnNewRequestItem">New Request Item</button><hr>
						<table id="tblRequest" class="table table-striped table-bordered">
							<thead>
								<th>Request No.</th>
								<th>Request Type</th>
								<th>Deployment Site</th>
								<th>Location</th>
								<th>Requested By</th>
								<th>Requested At</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="request-list">
								@foreach ($requests as $request)
								<tr id="id{{$request->requestid}}">
									<td>{{$request->requestid}}</td>
									<td>{{$request->type}}</td>
									<td>{{$request->deploymentsite->sitename}}</td>
									<td>{{$request->deploymentsite->location}}</td>
									@if ($request->account->client)
										<td>{{$request->account->client->lastname}}, {{$request->account->client->firstname}} {{$request->account->client->middlename}}</td>
									@else
										<td>{{$request->account->manager->lastname}}, {{$request->account->manager->firstname}} {{$request->account->manager->middlename}}</td>
									@endif
									<td>{{$request->datecreated->format('Y-m-d')}}</td>
									@if ($request->deleted_at != null)
										<td style="text-align: center;">DECLINED</td>
										<td></td>
									@elseif ($request->status == 0)
										@if ($request->type == "ITEM")
											<td style="text-align: center;">PENDING</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateItem" value="{{$request->requestid}}">Update</button>
												<button class="btn btn-danger btn-xs" id="btnCancel" value="{{$request->requestid}}">Cancel</button>
											</td>
										@elseif ($request->type == "PERSONNEL")
											<td style="text-align: center;">PENDING</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateQualification" value="{{$request->requestid}}">Update</button>
												@if (!$request->deploy)
													<button class="btn btn-danger btn-xs" id="btnCancel" value="{{$request->requestid}}">Cancel</button>
												@endif
											</td>
										@endif
									@elseif ($request->status == 1)
										@if ($request->type == "ITEM")
											<td style="text-align: center;">ITEM LIST RECEIVED</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnAcceptItem" value="{{$request->requestid}}">Assess</button>
											</td>
										@elseif ($request->type == "PERSONNEL")
											<td style="text-align: center;">SECURITY GUARD LIST RECEIVED</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnAcceptSecurityGuard" value="{{$request->requestid}}">Assess</button>
											</td>
										@endif
									@elseif ($request->status == 2)
										<td style="text-align: center;">COMPLETE</td>
										<td></td>
									@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for qualification -->
	<div class="modal fade" id="modalQualification">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<form id="formQualification" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Security Guard Qualification</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Deployment Site *</label>
							<select class="form-control" id="deploymentsitelistsg" required></select>
						</div>
	            		<div class="row">
	            			<div class="col-md-6">
		            			<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Number of security guard to hire *</label>
											<input type="text" id="requireno" class="form-control" placeholder="# of Security Guard" style="text-align: right;" pattern="^[1-9][0-9]*$" maxlength="5" required>
										</div>
										<div id="workingexperience-info" class="col-md-6" style="display: none;">
											<label>Working Experience *</label>
											<div class="column">
												<div class="col-md-8 no-padding">
													<input type="text" id="workexp" class="form-control" placeholder="Working Experience" style="text-align: right;" pattern="^[1-9][0-9]*$" maxlength="5">
												</div>
												<div class="col-md-4 no-padding">
					            					<select class="form-control" id="workingexperiencetype">
							              				<option value="day">Day(s)</option>
							              				<option value="month">Month(s)</option>
							              				<option value="year">Year(s)</option>
							              			</select>
							              		</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label><input type="checkbox" name="workingexperience" id="workingexperience">  Working Experience</label>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Gender *</label><br>
												<label><input type="checkbox" name="gender" id="gender" value="Male">  Male</label><br>
												<label><input type="checkbox" name="gender" id="gender" value="Female">  Female</label>
											</div>
											<div class="form-group">
												<label>Civil Status *</label><br>
												<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Single">  Single</label><br>
												<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Married">  Married</label><br>
												<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Divorced">  Divorced</label><br>
												<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Widowed">  Widowed</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Level of Attainment *</label><br>
												<label><input type="checkbox" name="attainment" id="attainment" value="Elementary">  Elementary</label><br>
												<label><input type="checkbox" name="attainment" id="attainment" value="High School">  High School</label><br>
												<label><input type="checkbox" name="attainment" id="attainment" value="College">  College</label><br>
												<label><input type="checkbox" name="attainment" id="attainment" value="Vocational">  Vocational</label>
											</div>
										</div>
									</div>
								</div>
		            		</div>
							<div class="col-md-6">
								<div class="form-group">
					                <label>Age *</label>
					                <div class="col-sm-12">
					              		<b>18  </b><input type="text" class="form-control" id="agerange" style="width: 80%"><b>  80</b>
					                </div>
								</div>
								<div class="form-group">
				                	<label>Height(cm) *</label>
				              		<div class="col-sm-12">
				              			<b>120  </b><input type="text" class="form-control" id="heightrange" style="width: 80%"><b>  300</b>
				              		</div>
								</div>
								<div class="form-group">
				                	<label>Weight(cm) *</label>
				              		<div class="col-sm-12">
				              			<b>40  </b><input type="text" class="form-control" id="weightrange" style="width: 80%"><b>  200</b>
				              		</div>
								</div><br>
								<div class="form-group">
									<label>Preferred:</label>
									<div class="row">
										<div class="col-md-4">
											<label>Age</label>
											<input type="text" class="form-control" id="preferage" placeholder="Age" pattern="^[1-9][0-9]*$" maxlength="4">
										</div>
										<div class="col-md-4">
											<label>Height</label>
											<input type="text" class="form-control" id="preferheight" placeholder="Height" pattern="^[1-9][0-9]*$" maxlength="4">
										</div>
										<div class="col-md-4">
											<label>Weight</label>
											<input type="text" class="form-control" id="preferweight" placeholder="Weight" pattern="^[1-9][0-9]*$" maxlength="4">
										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary pull-right" id="btnAddQualification">ADD</button>
			            		</div>
							</div>
	            		</div>
						<hr>
						<div class="form-group table-responsive">
							<table id="tblQualification" class="table table-striped table-bordered">
								<thead>
									<th># of SG</th>
									<th>Gender</th>
									<th>Attainment</th>
									<th>Civil Status</th>
									<th>Age (min,prefer,max)</th>
									<th>Height (min,prefer,max)</th>
									<th>Weight (min,prefer,max)</th>
									<th>Work Experience (months)</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="qualification-list"></tbody>
							</table>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="btnSaveQualification">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for security guard -->
	<div class="modal fade" id="modalSecurityGuard">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Security Guard List</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th style="min-width: 200px;">Name</th>
								<th style="text-align: center;">Work Experience(months)</th>
								<th style="text-align: center;">Distance(km)</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="securityguard-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnRequest">REQUEST</button>
						<button type="button" class="btn btn-primary" id="btnSaveSecurityGuard">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for security guard profile -->
	<div class="modal fade" id="modalProfile">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Profile</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<img id="pictureview" src="/applicant/default.png" alt="IMAGE" style="width: 35%; height: 35%;" class="center-block">
					</div>
					<div class="form-group table-responsive">
						<h3>Applicant Info</h3>
						<table class="table table-striped table-bordered">
							<tbody id="applicantinfo-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Education Background</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Graduate Type</th>
								<th>Degree</th>
								<th>Date Graduated</th>
								<th>School Graduated</th>
							</thead>
							<tbody id="education-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Employment Record</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Company</th>
								<th>Industry Type</th>
								<th>Duration (months)</th>
								<th>Reason For Leaving</th>
							</thead>
							<tbody id="employment-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Training Certificate</h3>
						<table class="table table-striped table-bordered">
							<thead>
								<th>Certificate</th>
								<th>Conducted By</th>
								<th>Date Conducted</th>
							</thead>
							<tbody id="training-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for request item -->
	<div class="modal fade" id="modalRequestItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRequestItem" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>New Request Item</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Deployment Site *</label>
							<select id="deploymentsitelistitem" class="form-control" required></select>
						</div>
						<div class="form-group table-responsive">
							<h3>Inventory</h3>
							<table id="tblInventory" class="table table-striped table-bordered">
								<thead>
									<th>Item Name</th>
									<th>Item Type</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="inventory-list"></tbody>
							</table>
						</div><hr>
						<h3>Request Item</h3>
						<div class="form-group table-responsive">
							<table id="tblRequestItem" class="table table-striped table-bordered">
								<thead>
									<th>Item Name</th>
									<th>Item Type</th>
									<th style="text-align: center;">Approx Quantity</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="requestitem-list"></tbody>
							</table>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSaveRequestItem">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for item -->
	<div class="modal fade" id="modalItem">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Item List</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group table-responsive">
						<h3>Firearm</h3>
						<table id="tblFirearm" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>License</th>
								<th>Expiration</th>
							</thead>
							<tbody id="firearm-list"></tbody>
						</table>
					</div>
					<div class="form-group table-responsive">
						<h3>Item</h3>
						<table id="tblItem" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>Item Type</th>
								<th>Quantity</th>
							</thead>
							<tbody id="item-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnReceiveItem">RECEIVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for cancel request -->
	<div class="modal fade" id="modalCancelConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to cancel this request?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for finalize the security guard -->
	<div class="modal fade" id="modalConfirmation">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to proceed?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnConfirm">CONFIRM</button>
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
	<script src="/js/custom/client/request.js"></script>
@endsection