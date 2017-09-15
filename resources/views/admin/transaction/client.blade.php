@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Client</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New Client</button><hr>
					<table id="tblClient" class="table table-striped table-bordered">
						<thead>
							<th>Company</th>
							<th>Address</th>
							<th>Contact No.</th>
							<th>Contact Person</th>
							<th>Contact Person No.</th>
							<th>Email</th>
							<th style="text-align: center;">Status</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="client-list">
							@foreach ($clients as $client)
							<tr id="id{{$client->clientid}}">
								<td>{{$client->company}}</td>
								<td>{{$client->address}}</td>
								<td>{{$client->companycontactno}}</td>
								<td>{{$client->lastname}}, {{$client->firstname}} {{$client->middlename}}</td>
								<td>{{$client->contactpersonno}}</td>
								<td>{{$client->email}}</td>
								@if ($client->status == 0)
								<td style="text-align: center;">NO DEPLOYMENT SITE</td>
								@elseif ($client->status == 1)
								<td style="text-align: center;">ACTIVE</td>
								@endif
								<td style="text-align: center;">
									<button class="btn btn-primary btn-xs" id="btnNewContract" value="{{$client->clientid}}">New Contract</button>
									<button class="btn btn-primary btn-xs" id="btnUpdate" value="{{$client->clientid}}">Update</button>
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

<!-- modal for new client -->
<div class="modal fade" id="modalClient">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="formClient" data-parsley-validate>
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>New Client</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<h3>Client Information</h3>
					<div class="form-group">
						<label>Last Name *</label>
						<input type="text" class="form-control" id="lastname" placeholder="Last Name" required>
					</div>
					<div class="form-group">
						<label>First Name *</label>
						<input type="text" class="form-control" id="firstname" placeholder="First Name" required>
					</div>
					<div class="form-group">
						<label>Middle Name</label>
						<input type="text" class="form-control" id="middlename" placeholder="Middle Name">
					</div>
					<div class="form-group">
						<label>Position *</label>
						<input type="text" class="form-control" id="position" placeholder="Position" required>
					</div>
					<div class="form-group">
						<label>Contact # *</label>
						<input type="text" class="form-control" id="contactpersonno" placeholder="Contact #" required>
					</div><hr>
					<h3>Account Information</h3>
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
					<h3>Company Details</h3>
					<div class="form-group">
						<label>Name *</label>
						<input type="text" class="form-control" id="companyname" placeholder="Name" required>
					</div>
					<div class="form-group">
						<label>Address *</label>
						<input type="text" class="form-control" id="companyaddress" placeholder="Address" required>
					</div>
					<div class="form-group">
						<label>Contact # *</label>
						<input type="text" class="form-control" id="companycontactno" placeholder="Contact #" required>
					</div>
					<div class="form-group">
						<label>Email *</label>
						<input type="email" class="form-control" id="companyemail" placeholder="Email" required>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button class="btn btn-primary" id="btnClientSubmit">SAVE</button>
						<button class="btn btn-default" type="button" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal for update client -->
<div class="modal fade" id="modalUpdateClient">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- modal header -->
			<div class="modal-header">
				<button class="close" data-dismiss="modal">&times;</button>
				<h3>Update Client</h3>
			</div>
			<!-- modal body -->
			<div class="modal-body">
				<div class="wizard">
					<div class="wizard-inner">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active" id="1">
								<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Company Details">
									<span class="round-tab">
										<i class="glyphicon glyphicon-list-alt"></i>
									</span>
								</a>
							</li>

							<li role="presentation" id="2">
								<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Client Information">
									<span class="round-tab">
										<i class="glyphicon glyphicon-info-sign"></i>
									</span>
								</a>
							</li>

							<li role="presentation" id="3">
								<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Account Information">
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
									<form id="formCompanyDetails" data-parsley-validate>
										<div class="form-group">
											<h4>Company Details</h4>
										</div>
										<div class="form-group">
											<label>Name *</label>
											<input type="text" class="form-control" id="updatecompanyname" placeholder="Name" required>
										</div>
										<div class="form-group">
											<label>Address *</label>
											<input type="text" class="form-control" id="updatecompanyaddress" placeholder="Address" required>
										</div>
										<div class="form-group">
											<label>Contact # *</label>
											<input type="text" class="form-control" id="updatecompanycontactno" placeholder="Contact #" required>
										</div>
										<div class="form-group">
											<label>Email *</label>
											<input type="email" class="form-control" id="updatecompanyemail" placeholder="Email" required>
										</div>
										<div class="form-group">
											<button class="btn btn-primary pull-right" id="btnCompanyDetailsSave">SAVE</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="tab-pane" role="tabpanel" id="step2">
							<div class="box box-primary">
								<div class="box-body">
									<form id="formClientInformation" data-parsley-validate>
										<div class="form-group">
											<h4>Client Information</h4>
										</div>
										<div class="form-group">
											<label>Last Name *</label>
											<input type="text" class="form-control" id="updatelastname" placeholder="Last Name" required>
										</div>
										<div class="form-group">
											<label>First Name *</label>
											<input type="text" class="form-control" id="updatefirstname" placeholder="First Name" required>
										</div>
										<div class="form-group">
											<label>Middle Name</label>
											<input type="text" class="form-control" id="updatemiddlename" placeholder="Middle Name">
										</div>
										<div class="form-group">
											<label>Position *</label>
											<input type="text" class="form-control" id="updateposition" placeholder="Position" required>
										</div>
										<div class="form-group">
											<label>Contact # *</label>
											<input type="text" class="form-control" id="updatecontactpersonno" placeholder="Contact #" required>
										</div>
										<div class="form-group">
											<button class="btn btn-primary pull-right" id="btnClientInformationSave">SAVE</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="tab-pane" role="tabpanel" id="step3">
							<div class="box box-primary">
								<div class="box-body">
									<form id="formAccountInformation" data-parsley-validate>
										<div class="form-group">
											<h4>Account Information</h4>
										</div>
										<div class="form-group">
											<label>New Username *</label>
											<input type="text" class="form-control" id="updateusername" placeholder="Username" required>
										</div>
										<div class="form-group">
											<label>New Password *</label>
											<input type="password" class="form-control input-password" id="updatepassword" placeholder="Password" required>
										</div>
										<div class="form-group">
											<label>Confirm Password *</label>
											<input type="password" class="form-control input-confirmpassword" id="updateconfirmpassword" placeholder="Confirm Password" required>
										</div>
										<div class="form-group">
											<button class="btn btn-primary pull-right" id="btnAccountInformationSave">SAVE</button>
										</div>
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

<!-- modal for new contract -->
<div class="modal fade" id="modalContract">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="formContract" data-parsley-validate>
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>New Contract</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<h3>CONTRACT DETAILS</h3>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Start Date *</label>
								<input type="text" class="form-control mydatepicker" id="startdate" placeholder="yyyy-mm-dd" required>
							</div>
							<div class="col-md-6">
								<label>Area Type *</label>
								<select class="form-control" id="inputAreaType" required></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Length *</label>
						<div class="row">
							<div class="col-md-12">
								<div class="column">
									<div class="col-md-9 no-padding">
										<input type="text" id="inputLength" class="form-control" placeholder="Length" style="text-align: right;" pattern="^[1-9][0-9]*$" required>
									</div>
									<div class="col-md-3 no-padding">
										<select class="form-control" id="lengthtype">
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
						<label>Price *</label>
						<div class="input-group">
							<span class="input-group-addon"><i>&#8369;</i></span>
							<input type="text" id="inputPrice" class="form-control" placeholder="Contract Price" style="text-align: right;" required>
						</div>
					</div>
					<div class="form-group">
						<label>Place Held *</label>
						<input type="text" id="inputPlaceHeld" class="form-control" placeholder="Place Held" required>
					</div>
					<div class="form-group">
						<label>Building/Area Name *</label>
						<input type="text" id="inputBuildingAreaName" class="form-control" placeholder="Building/Area Name" required>
					</div>
					<div class="form-group">
						<label>Address *</label>
						<input type="text" id="inputAddress" class="form-control" placeholder="Address" required>
					</div>
					<div class="form-group">
						<label>Province *</label>
						<select class="form-control" id="inputProvince" required>
							<option></option>
							<option value="Abra">Abra</option>
							<option value="Agusan Del Norte">Agusan Del Norte</option>
							<option value="Agusan Del Sur">Agusan Del Sur</option>
							<option value="Aklan">Aklan</option>
							<option value="Albay">Albay</option>
							<option value="Antique">Antique</option>
							<option value="Apayao">Apayao</option>
							<option value="Aurora">Aurora</option>
							<option value="Basilan">Basilan</option>
							<option value="Bataan">Bataan</option>
							<option value="Batanes">Batanes</option>
							<option value="Batangas">Batangas</option>
							<option value="Benguet">Benguet</option>
							<option value="Biliran">Biliran</option>
							<option value="Bohol">Bohol</option>
							<option value="Bukidnon">Bukidnon</option>
							<option value="Bulacan">Bulacan</option>
							<option value="Cagayan">Cagayan</option>
							<option value="Camarines Norte">Camarines Norte</option>
							<option value="Camarines Sur">Camarines Sur</option>
							<option value="Camiguin">Camiguin</option>
							<option value="Capiz">Capiz</option>
							<option value="Catanduanes">Catanduanes</option>
							<option value="Cavite">Cavite</option>
							<option value="Cebu">Cebu</option>
							<option value="Compostella Valley">Compostella Valley</option>
							<option value="Cotabato">Cotabato</option>
							<option value="Davao Del Norte">Davao Del Norte</option>
							<option value="Davao Del Sur">Davao Del Sur</option>
							<option value="Davao Occidental">Davao Occidental</option>
							<option value="Davao Oriental">Davao Oriental</option>
							<option value="Dinagat Islands">Dinagat Islands</option>
							<option value="Eastern Samar">Eastern Samar</option>
							<option value="Guimaras">Guimaras</option>
							<option value="Ifugao">Ifugao</option>
							<option value="Ilocos Norte">Ilocos Norte</option>
							<option value="Ilocos Sur">Ilocos Sur</option>
							<option value="Iloilo">Iloilo</option>
							<option value="Isabela">Isabela</option>
							<option value="Kalinga">Kalinga</option>
							<option value="La Union">La Union</option>
							<option value="Laguna">Laguna</option>
							<option value="Lanao Del Norte">Lanao Del Norte</option>
							<option value="Lanao Del Sur">Lanao Del Sur</option>
							<option value="Leyte">Leyte</option>
							<option value="Maguindanao">Maguindanao</option>
							<option value="Marinduque">Marinduque</option>
							<option value="Masbate">Masbate</option>
							<option value="Metro Manila">Metro Manila</option>
							<option value="Misamis Occidental">Misamis Occidental</option>
							<option value="Misamis Oriental">Misamis Oriental</option>
							<option value="Mountain Province">Mountain Province</option>
							<option value="Negros Occidental">Negros Occidental</option>
							<option value="Negros Oriental">Negros Oriental</option>
							<option value="Northern Samar">Northern Samar</option>
							<option value="Nueva Ecija">Nueva Ecija</option>
							<option value="Nueva Vizcaya">Neuva Vizcaya</option>
							<option value="Occidental Mindoro">Occidental Mindoro</option>
							<option value="Oriental Mindoro">Oriental Mindoro</option>
							<option value="Palawan">Palawan</option>
							<option value="Pampanga">Pampanga</option>
							<option value="Pangasinan">Pangasinan</option>
							<option value="Quezon">Quezon</option>
							<option value="Quirino">Quirino</option>
							<option value="Rizal">Rizal</option>
							<option value="Romblon">Romblon</option>
							<option value="Samar">Samar</option>
							<option value="Sarangani">Sarangani</option>
							<option value="Siquijor">Siquijor</option>
							<option value="Sorsogon">Sorsogon</option>
							<option value="South Cotabato">South Cotabato</option>
							<option value="Southern Leyte">Southern Leyte</option>
							<option value="Sultan Kudarat">Sultan Kudarat</option>
							<option value="Sulu">Sulu</option>
							<option value="Surigao Del Norte">Surigao Del Norte</option>
							<option value="Surigao Del Sur">Surigao Del Sur</option>
							<option value="Tarlac">Tarlac</option>
							<option value="Tawi-Tawi">Tawi-Tawi</option>
							<option value="Zambales">Zambales</option>
							<option value="Zamboanga Del Norte">Zamboanga Del Norte</option>
							<option value="Zamboanga Del Sur">Zamboanga Del Sur</option>
							<option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
						</select>
					</div>
					<div class="form-group">
						<label>City/Municipality *</label>
						<select class="form-control" id="inputCity" required></select>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="btnContractSubmit">SAVE</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
<meta name="AuthenticatedID" content="{{ Auth::user()->admin->adminid }}" />
@endsection

@section('script')
<script src="/js/custom/admin/transaction/client.js"></script>
@endsection