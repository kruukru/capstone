@extends('client.templates.default')

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
							<tbody id="deploy-list">
								@foreach ($deploymentsites as $deploymentsite)
									<tr id="id{{$deploymentsite->deploymentsiteid}}">
										<td>{{$deploymentsite->sitename}}</td>
										<td>{{$deploymentsite->location}} {{$deploymentsite->city}} {{$deploymentsite->province}}</td>
										@if ($deploymentsite->status == 0)
											<td style="text-align: center;">QUALIFICATION LIST</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnQualification" value="{{$deploymentsite->deploymentsiteid}}">Send Qualification</button>
											</td>
										@elseif ($deploymentsite->status == 1)
											<td style="text-align: center;">PENDING REQUEST</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnUpdate" value="{{$deploymentsite->deploymentsiteid}}">Update</button>
											</td>
										@elseif ($deploymentsite->status == 2)
											<td style="text-align: center;">SECURITY GUARD LIST RECEIVE</td>
											<td style="text-align: center;">
												<button class="btn btn-primary btn-xs" id="btnSGList" value="{{$deploymentsite->deploymentsiteid}}">Assess</button>
											</td>
										@elseif ($deploymentsite->status == 3)
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
		            			<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Number of security guard to hire *</label>
											<input type="text" id="requireno" class="form-control" placeholder="# of Security Guard" style="text-align: right;" pattern="^[1-9][0-9]*$" required>
										</div>
										<div id="workingexperience-info" class="col-md-6" style="display: none;">
											<label>Working Experience *</label>
											<div class="column">
												<div class="col-md-8 no-padding">
													<input type="text" id="workexp" class="form-control" placeholder="Working Experience" style="text-align: right;" pattern="^[1-9][0-9]*$">
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
					              		<b>18  </b><input type="text" class="form-control" id="agerange" style="width: 90%"><b>  80</b>
					                </div>
								</div>
								<div class="form-group">
				                	<label>Height(cm) *</label>
				              		<div class="col-sm-12">
				              			<b>120  </b><input type="text" class="form-control" id="heightrange" style="width: 90%"><b>  300</b>
				              		</div>
								</div>
								<div class="form-group">
				                	<label>Weight(cm) *</label>
				              		<div class="col-sm-12">
				              			<b>40  </b><input type="text" class="form-control" id="weightrange" style="width: 90%"><b>  200</b>
				              		</div>
								</div><br>
								<div class="form-group">
									<label>Preferred:</label>
									<div class="row">
										<div class="col-md-4">
											<label>Age *</label>
											<input type="text" class="form-control" id="preferage" placeholder="Age" pattern="^[1-9][0-9]*$" required>
										</div>
										<div class="col-md-4">
											<label>Height *</label>
											<input type="text" class="form-control" id="preferheight" placeholder="Height" pattern="^[1-9][0-9]*$" required>
										</div>
										<div class="col-md-4">
											<label>Weight *</label>
											<input type="text" class="form-control" id="preferweight" placeholder="Weight" pattern="^[1-9][0-9]*$" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary pull-right" id="btnQualificationAdd">ADD</button>
			            		</div>
							</div>
	            		</div>
						<hr>
						<div class="form-group">
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
						<button class="btn btn-primary" id="btnQualificationSave">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</form>
			</div>
		</div>
	</div>

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
					<table id="tblSecurityGuard" class="table table-striped table-bordered">
						<thead>
							<th>Name</th>
							<th style="text-align: center;">Work Experience(months)</th>
							<th style="text-align: center;">Distance(km)</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="securityguard-list"></tbody>
					</table>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnSGSave">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
	<style type="text/css">
		.slider-selection {
			background: lightblue;
		}
	</style>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/client/deploymentsite.js"></script>
@endsection