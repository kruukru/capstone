@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Utility - Account</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button id="btnNew" class="btn btn-primary btn-md">New Account</button><hr>
						<table id="tblAccount" class="table table-striped table-bordered">
							<thead>
								<th>Account Name</th>
								<th>Username</th>
								<th>Position</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="account-list">
								@foreach ($accounts as $account)
								<tr id="id{{$account->accountid}}">
									<td>{{$account->admin->lastname}}, {{$account->admin->firstname}} {{$account->admin->middlename}}</td>
									<td>{{$account->username}}</td>
									<td>{{$account->admin->position}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$account->accountid}}">Update</button>
										@if ($account->accountid != 1)
											<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$account->accountid}}">Remove</button>
										@endif
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
	<div class="modal fade" id="modalAccount">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formAccount" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>New Account</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Last Name <span class="asterisk-red">*</span></label>
							<input type="text" class="form-control" id="lastname" placeholder="Last Name" required>
						</div>
						<div class="form-group">
							<label>First Name <span class="asterisk-red">*</span></label>
							<input type="text" class="form-control" id="firstname" placeholder="First Name" required>
						</div>
						<div class="form-group">
							<label>Middle Name</label>
							<input type="text" class="form-control" id="middlename" placeholder="Middle Name">
						</div>
						<div class="form-group">
							<label>Position <span class="asterisk-red">*</span></label>
							<select class="form-control" id="position">
								<option value="Executive">Executive</option>
								<option value="Admin">Admin</option>
								<option value="Operation">Operation</option>
								<option value="HR">HR</option>
							</select>
						</div><hr>
						<div class="form-group">
							<label>Username <span class="asterisk-red">*</span></label>
							<input type="text" class="form-control" id="username" placeholder="Username" required>
						</div>
						<div class="form-group">
							<label>Password <span class="asterisk-red">*</span></label>
							<input type="password" class="form-control input-password" id="password" placeholder="Password" required>
						</div>
						<div class="form-group">
							<label>Confirm Password <span class="asterisk-red">*</span></label>
							<input type="password" class="form-control input-confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-primary" id="btnSave">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for update client -->
	<div class="modal fade" id="modalUpdateAccount">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Update Account</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="wizard">
						<div class="wizard-inner">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active" id="1">
									<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Admin Information">
										<span class="round-tab">
											<i class="glyphicon glyphicon-list-alt"></i>
										</span>
									</a>
								</li>

								<li role="presentation" id="2">
									<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Account Information">
										<span class="round-tab">
											<i class="glyphicon glyphicon-info-sign"></i>
										</span>
									</a>
								</li>

								<li role="presentation" id="3">
									<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Profile Image">
										<span class="round-tab">
											<i class="glyphicon glyphicon-user"></i>
										</span>
									</a>
								</li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" role="tabpanel" id="step1">
								<div class="box box-primary">
									<div class="box-body">
										<form id="formAdminInformation" data-parsley-validate>
											<div class="form-group">
												<label>Last Name <span class="asterisk-red">*</span></label>
												<input type="text" class="form-control" id="updatelastname" placeholder="Last Name" required>
											</div>
											<div class="form-group">
												<label>First Name <span class="asterisk-red">*</span></label>
												<input type="text" class="form-control" id="updatefirstname" placeholder="First Name" required>
											</div>
											<div class="form-group">
												<label>Middle Name</label>
												<input type="text" class="form-control" id="updatemiddlename" placeholder="Middle Name">
											</div>
											<div class="form-group">
												<label>Position <span class="asterisk-red">*</span></label>
												<select class="form-control" id="updateposition">
													<option value="Executive">Executive</option>
													<option value="Admin">Admin</option>
													<option value="Operation">Operation</option>
													<option value="HR">HR</option>
												</select>
											</div>
											<div class="form-group">
												<button class="btn btn-primary pull-right" id="btnSaveAdminInformation">SAVE</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="tab-pane" role="tabpanel" id="step2">
								<div class="box box-primary">
									<div class="box-body">
										<form id="formAccountInformation" data-parsley-validate>
											<div class="form-group">
												<label>New Username <span class="asterisk-red">*</span></label>
												<input type="text" class="form-control" id="updateusername" placeholder="Username" required>
											</div>
											<div class="form-group">
												<label>New Password <span class="asterisk-red">*</span></label>
												<input type="password" class="form-control input-updatepassword" id="updatepassword" placeholder="Password" required>
											</div>
											<div class="form-group">
												<label>Confirm Password <span class="asterisk-red">*</span></label>
												<input type="password" class="form-control input-updateconfirmpassword" id="updateconfirmpassword" placeholder="Confirm Password" required>
											</div>
											<div class="form-group">
												<button class="btn btn-primary pull-right" id="btnSaveAccountInformation">SAVE</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="tab-pane" role="tabpanel" id="step3">
								<div class="box box-primary">
									<div class="box-body">
										<form id="formImage" enctype="multipart/form-data" role="form" method="POST" action="">
											<h3>PROFILE IMAGE</h3>
											<div class="form-group">
												<img id="pictureview" src="/admin/default.png" alt="IMAGE" style="width: 50%; height: 50%;" class="center-block">
											</div>
											<div class="form-group">
												<div class="column">
													<div class="col-md-11 no-padding">
														<input type="file" class="form-control" name="picture" id="picture" accept="image/*" data-type='image'>
													</div>
													<div class="col-md-1 no-padding">
														<button class="btn btn-primary pull-right" id="btnSaveImage">SAVE</button>
													</div>
												</div>
											</div>
											<input type="hidden" name="_token" value="{{ Session::token() }}">
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalAccountRemove">
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
	<script src="/js/custom/admin/utility/account.js"></script>
@endsection