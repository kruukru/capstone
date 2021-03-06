@extends(Auth::user()->accounttype == 10 ? 'client.templates.default' : 'manager.templates.default')

@section('content')
	<section class="content-header">
		<h1>Deployment Site</h1>
	</section>
	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblDeploymentSite" class="table table-striped table-bordered">
							<thead>
								<th>Deployment Site</th>
								<th>Address</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deploymentsite-list">
								@foreach ($deploymentsites as $deploymentsite)
									<tr id="id{{$deploymentsite->deploymentsiteid}}">
										<td>{{$deploymentsite->sitename}}</td>
										<td>{{$deploymentsite->location}} {{$deploymentsite->city}} {{$deploymentsite->province}}</td>
										@if ($deploymentsite->contract->status == 1)
											<td style="text-align: center;">EXPIRED</td>
											<td></td>
										@elseif ($deploymentsite->contract->status == 2)
											<td style="text-align: center;">TERMINATED</td>
											<td></td>
										@elseif ($deploymentsite->status == 0)
											<td style="text-align: center;">QUALIFICATION LIST</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnQualification" value="{{$deploymentsite->deploymentsiteid}}">Send Qualification</button>
											</td>
										@elseif ($deploymentsite->status == 1)
											<td style="text-align: center;">PENDING REQUEST</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdateQualification" value="{{$deploymentsite->deploymentsiteid}}">Update</button>
											</td>
										@elseif ($deploymentsite->status == 2)
											<td style="text-align: center;">SECURITY GUARD LIST RECEIVED</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnSGList" value="{{$deploymentsite->deploymentsiteid}}">Assess</button>
											</td>
										@elseif ($deploymentsite->status == 3)
											<td style="text-align: center;">PENDING ITEMS</td>
											<td style="text-align: center;"></td>
										@elseif ($deploymentsite->status == 4)
											<td style="text-align: center;">ITEMS RECEIVE</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnItem" value="{{$deploymentsite->deploymentsiteid}}">Assess</button>
											</td>
										@elseif ($deploymentsite->status == 5)
											<td style="text-align: center;">ACTIVE</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnView" value="{{$deploymentsite->deploymentsiteid}}">View</button>
											</td>
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
	            		<div class="row">
	            			<div class="col-md-6">
	            				<div class="box box-primary">
	            					<div class="box-header with-border">
                        				<h3 class="box-title">Qualification</h3>
                        			</div>
	            					<div class="box-body">
	            						<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Number of security guard to hire <span class="asterisk-red">*</span></label>
													<input type="text" id="requireno" class="form-control" placeholder="# of Security Guard" style="text-align: right;" pattern="^[1-9][0-9]*$" maxlength="5" required>
												</div>
												<div id="workingexperience-info" class="col-md-6" style="display: none;">
													<label>Working Experience</label>
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
												<div class="col-md-4">
													<div class="form-group">
														<label>Level of Attainment <span class="asterisk-red">*</span></label><br>
														<label><input type="checkbox" name="attainment" id="attainment" value="Elementary">  Elementary</label><br>
														<label><input type="checkbox" name="attainment" id="attainment" value="High School">  High School</label><br>
														<label><input type="checkbox" name="attainment" id="attainment" value="College">  College</label><br>
														<label><input type="checkbox" name="attainment" id="attainment" value="Vocational">  Vocational</label>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Gender <span class="asterisk-red">*</span></label><br>
														<label><input type="checkbox" name="gender" id="gender" value="Male">  Male</label><br>
														<label><input type="checkbox" name="gender" id="gender" value="Female">  Female</label>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Civil Status <span class="asterisk-red">*</span></label><br>
														<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Single">  Single</label><br>
														<label><input type="checkbox" name="civilstatus" id="civilstatus" value="Married">  Married</label>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-primary pull-right" id="btnAddQualification">ADD</button>
					            		</div>
	            					</div>
	            				</div>
		            		</div>
							<div class="col-md-6">
								<div class="box box-primary">
									<div class="box-header with-border">
                        				<h3 class="box-title">Age / Height / Weight</h3>
                        			</div>
									<div class="box-body">
										<div class="form-group">
							                <label>Age</label>
							                <div class="col-sm-12">
							              		<b>18  </b><input type="text" class="form-control" id="agerange" style="width: 82%"><b>  80</b>
							                </div>
										</div>
										<div class="form-group">
						                	<label>Height(cm)</label>
						              		<div class="col-sm-12">
						              			<b>120  </b><input type="text" class="form-control" id="heightrange" style="width: 80%"><b>  300</b>
						              		</div>
										</div>
										<div class="form-group">
						                	<label>Weight(kg)</label>
						              		<div class="col-sm-12">
						              			<b>40  </b><input type="text" class="form-control" id="weightrange" style="width: 81%"><b>  200</b>
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
									</div>
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
						<button type="button" class="btn btn-primary" id="btnReceive">RECEIVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalDeploymentSite">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Deployment Site</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group table-responsive">
						<table class="table table-striped table-bordered">
							<tbody id="deploymentsite-info"></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive">
						<h4>Security Guard</h4>
						<table id="tblViewSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="viewsecurityguard-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive">
						<h4>Item</h4>
						<table id="tblViewItem" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>Item Type</th>
								<th>Quantity</th>
							</thead>
							<tbody id="viewitem-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group table-responsive">
						<h4>Firearm</h4>
						<table id="tblViewFirearm" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>License</th>
								<th>Expiration</th>
							</thead>
							<tbody id="viewfirearm-list"></tbody>
						</table>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/client/deploymentsite.js"></script>
@endsection