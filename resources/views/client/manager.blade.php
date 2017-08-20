@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Manager</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<button class="btn btn-primary btn-md" id="btnNew">New Manager</button><hr>
						<table id="tblManager" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>Username</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="manager-list">
								@foreach ($managers as $manager)
								<tr id="id{{$manager->managerid}}">
									<td>{{$manager->lastname}}, {{$manager->firstname}} {{$manager->middlename}}</td>
									<td>{{$manager->account->username}}</td>
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnAssign" value="{{$manager->managerid}}">Assign</button>
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$manager->managerid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$manager->managerid}}">Remove</button>
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

	<!-- modal for new -->
	<div class="modal fade" id="modalManager">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formManager" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>New Manager</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
        					<label>Username *</label>
        					<input type="text" class="form-control" id="username" placeholder="Username" required>
        				</div>
        				<div class="form-group">
        					<label>Password *</label>
        					<input type="password" class="form-control input-password" id="password" placeholder="Password" required>
        				</div>
        				<div class="form-group">
        					<label>Confirm Password *</label>
        					<input type="password" class="form-control input-confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
        				</div><hr>
        				<div class="form-group">
        					<label>Lastname *</label>
        					<input type="text" class="form-control" id="inputLastname" placeholder="Lastname" required>
        				</div>
        				<div class="form-group">
        					<label>Firstname *</label>
        					<input type="text" class="form-control" id="inputFirstname" placeholder="Firstname" required>
        				</div>
        				<div class="form-group">
        					<label>Middlename</label>
        					<input type="text" class="form-control" id="inputMiddlename" placeholder="Middlename">
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

	<!-- modal for update -->
	<div class="modal fade" id="modalManagerUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Update Manager</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<form id="formAccountUpdate" data-parsley-validate>
						<div class="form-group">
	    					<label>New Username *</label>
	    					<input type="text" class="form-control" id="updateusername" placeholder="Username" required>
	    				</div>
	    				<div class="form-group">
	    					<label>New Password *</label>
	    					<input type="password" class="form-control updateinput-password" id="updatepassword" placeholder="Password" required>
	    				</div>
	    				<div class="form-group">
	    					<label>Confirm Password *</label>
	    					<input type="password" class="form-control updateinput-confirmpassword" id="updateconfirmpassword" placeholder="Confirm Password" required>
	    				</div>
	    				<div class="form-group">
							<button class="btn btn-primary" id="btnAccountSave" >SAVE</button>
						</div>
					</form>
    				<hr>
					<form id="formManagerUpdate" data-parsley-validate>
	    				<div class="form-group">
	    					<label>Lastname *</label>
	    					<input type="text" class="form-control" id="updateinputLastname" placeholder="Lastname" required>
	    				</div>
	    				<div class="form-group">
	    					<label>Firstname *</label>
	    					<input type="text" class="form-control" id="updateinputFirstname" placeholder="Firstname" required>
	    				</div>
	    				<div class="form-group">
	    					<label>Middlename</label>
	    					<input type="text" class="form-control" id="updateinputMiddlename" placeholder="Middlename">
	    				</div>
	    				<div class="form-group">
							<button class="btn btn-primary" id="btnManagerSave" >SAVE</button>
	        				<button class="btn btn-default pull-right" data-dismiss="modal">CANCEL</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for assign -->
	<div class="modal fade" id="modalAssign">
		<div class="modal-dialog modal-70">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Assign Manager</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label>Manager Name:</label>
						<h3 id="managerName"></h3>
					</div><hr>
					<div class="form-group">
						<h3>DEPLOYMENT SITE LIST</h3>
						<table id="tblDeploymentSite" class="table table-striped table-bordered">
							<thead>
								<th>Deployment Site</th>
								<th>Address</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="deploymentsite-list"></tbody>
						</table>
					</div><hr>
					<div class="form-group">
						<h3>ASSIGNED DEPLOYMENT SITE</h3>
						<table id="tblAssignDeploymentSite" class="table table-striped table-bordered">
							<thead>
								<th>Deployment Site</th>
								<th>Address</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="assigndeploymentsite-list"></tbody>
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

	<!-- modal for remove -->
	<div class="modal fade" id="modalManagerRemove">
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
	<script src="/js/custom/client/manager.js"></script>
@endsection