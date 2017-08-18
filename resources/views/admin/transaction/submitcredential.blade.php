@extends('admin.templates.default')

@section('content')
	<section class="content-header">
		<h1>Submit Credentials</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblApplicant" class="table table-striped table-bordered">
							<thead>
								<th>Applicant No.</th>
								<th>Name</th>
								<th>Appointment No.</th>
								<th>Date</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="applicant-list">
								@foreach ($applicants as $applicant)
								<tr id="id{{$applicant->applicantid}}">
									<td>{{$applicant->applicantid}}</td>
									<td>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
									<td>{{$applicant->appointment->appointmentid}}</td>
									<td>{{$applicant->appointment->appointmentdate->date->format('l, M. d, Y')}}</td>
									@if ($applicant->status == 0)
										<td style="text-align: center;">FOR SUBMISSION</td>
									@else
										<td style="text-align: center;">FOR FOLLOW UP</td>
									@endif
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnAssess" value="{{$applicant->applicantid}}">Assess</button>
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

	<div class="modal fade" id="modalCredential">
		<div class="modal-dialog modal-90">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Assess Credentials</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					<div class="wizard">
			            <div class="wizard-inner">
			                <ul class="nav nav-tabs" role="tablist">

			                	<li role="presentation" class="active" id="1">
			                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="STEP 1">
			                            <span class="round-tab">
			                                <i class="glyphicon glyphicon-user"></i>
			                            </span>
			                        </a>
			                    </li>

			                    <li role="presentation" id="2">
			                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="STEP 2">
			                            <span class="round-tab">
			                                <i class="glyphicon glyphicon-info-sign"></i>
			                            </span>
			                        </a>
			                    </li>

			                    <li role="presentation" id="3">
			                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="STEP 3">
			                            <span class="round-tab">
			                                <i class="glyphicon glyphicon-list-alt"></i>
			                            </span>
			                        </a>
			                    </li>

			                    <li role="presentation" id="4">
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
		                    		<div class="box-body">
		                    			<form id="formPersonalInformation" data-parsley-validate>
		                    				<div class="col-md-offset-1">
			                    				<h3>PERSONAL INFORMATION</h3>
			                    			</div>
			                    			<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-3 col-md-offset-1">
							            				<label>Last Name *</label>
							            				<input type="text" class="form-control" id="lastname" placeholder="Last Name" required>
							            			</div>
							            			<div class="col-md-3">
							            				<label>First Name *</label>
							            				<input type="text" class="form-control" id="firstname" placeholder="First Name" required>
							            			</div>
							            			<div class="col-md-3">
							            				<label>Middle Name</label>
							            				<input type="text" class="form-control" id="middlename" placeholder="Middle Name">
							            			</div>
							            			<div class="col-md-1">
							            				<label>Suffix</label>
							            				<input type="text" class="form-control" id="suffix" placeholder="Suffix">
							            			</div>
							            		</div>
							            	</div>
							            	<hr>
							            	<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-2 col-md-offset-1">
							            				<label>Birthdate *</label>
							            				<input type="text" class="form-control mydatepicker" id="dateofbirth" placeholder="yyyy-mm-dd" required>
							            			</div>
							            			<div class="col-md-1">
							            				<label>Age</label>
							            				<input type="text" class="form-control" id="age" disabled>
							            			</div>
							            			<div class="col-md-5">
							            				<label>Birthplace *</label>
							            				<input type="text" class="form-control" id="placeofbirth" placeholder="Birthplace" required>
							            			</div>
							            			<div class="col-md-2">
							            				<label>Contact # *</label>
							            				<input type="text" class="form-control" id="appcontactno" placeholder="Contact #" required>
							            			</div>
							            		</div>
							            	</div>
							            	<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-1 col-md-offset-1">
							            				<label>Gender *</label><br>
							            				<label><input type="radio" name="gender" id="gender" value="Male" checked> Male</label><br>
							            				<label><input type="radio" name="gender" id="gender" value="Female"> Female</label>
							            			</div>
							            			<div class="col-md-2">
							            				<label>Civil Status *</label>
							            				<select class="form-control" id="civilstatus">
								              				<option value="Single">Single</option>
								              				<option value="Married">Married</option>
								              				<option value="Divorced">Divorced</option>
								              				<option value="Widowed">Widowed</option>
								              			</select>
							            			</div>
							            			<div class="col-md-2">
							            				<label>Religion *</label>
							            				<select class="form-control" id="religion" required>
								              				<option value="Roman Catholic">Roman Catholic</option>
								              				<option value="Islam">Islam</option>
								              				<option value="Evangelicals">Evangelicals</option>
								              				<option value="Iglesia Ni Cristo">Iglesia Ni Cristo</option>
								              				<option value="Protestantism">Protestantism</option>
								              				<option value="Aglipayan">Aglipayan</option>
								              				<option value="Seventh-day Adventist">Seventh-day Adventist</option>
								              				<option value="Bible Baptist Church">Bible Baptist Church</option>
								              				<option value="United Church of Christ">United Church of Christ</option>
								              				<option value="Jehovah's Witnesses">Jehovah's Witnesses</option>
								              				<option value="Church of Christ">Church of Christ</option>
								              				<option value="Jesus is Lord Church">Jesus is Lord Church</option>
								              				<option value="United Pentecostal Church">United Pentecostal Church</option>
								              			</select>
							            			</div>
							            			<div class="col-md-2">
							            				<label>Height *</label>
							            				<div class="column">
							            					<div class="col-md-6 no-padding">
								            					<input type="text" class="form-control" id="height" placeholder="Height" style="text-align: right;" pattern="\d+(\.\d{1,2})?" required>
								            				</div>
								            				<div class="col-md-6 no-padding">
								            					<select class="form-control" id="heighttype">
										              				<option value="cm">cm</option>
										              				<option value="m">m</option>
										              				<option value="ft">ft</option>
										              			</select>
										              		</div>
										              	</div>
							            			</div>
							            			<div class="col-md-2">
							            				<label>Weight *</label>
							            				<div class="column">
							            					<div class="col-md-6 no-padding">
								            					<input type="text" class="form-control" id="weight" placeholder="Weight" style="text-align: right;" pattern="\d+(\.\d{1,2})?" required>
								            				</div>
								            				<div class="col-md-6 no-padding">
								            					<select class="form-control" id="weighttype">
										              				<option value="kg">kg</option>
										              				<option value="lbs">lbs</option>
										              			</select>
										              		</div>
										              	</div>
							            			</div>
							            			<div class="col-md-1">
							            				<label>Blood Type *</label>
							            				<select class="form-control" id="bloodtype">
								              				<option value="A+">A+</option>
								              				<option value="A-">A-</option>
								              				<option value="B+">B+</option>
								              				<option value="B-">B-</option>
								              				<option value="AB+">AB+</option>
								              				<option value="AB-">AB-</option>
								              				<option value="O+">O+</option>
								              				<option value="O-">O-</option>
								              			</select>
							            			</div>
							            		</div>
							            	</div>
							            	<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-4 col-md-offset-1">
							            				<label>City Address *</label>
							            				<input type="text" class="form-control" id="cityaddress" placeholder="City Address" required>
							            			</div>
							            			<div class="col-md-3">
							            				<label>Province *</label>
							            				<select class="form-control" id="cityaddressprovince" required>
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
							            			<div class="col-md-3">
							            				<label>City/Municipality *</label>
							            				<select class="form-control" id="cityaddresscity" required></select>
							            			</div>
							            		</div>
							            	</div>
							            	<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-4 col-md-offset-1">
							            				<label>Provincial Address</label>
							            				<input type="text" class="form-control" id="provincialaddress" placeholder="Provincial Address">
							            			</div>
							            			<div class="col-md-3">
							            				<label>Province</label>
								            				<select class="form-control" id="provincialaddressprovince">
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
							            			<div class="col-md-3">
							            				<label>City/Municipality</label>
							            				<select class="form-control" id="provincialaddresscity">
								              				<option></option>
								              			</select>
							            			</div>
							            		</div>
							            	</div>
							            	<div class="form-group">
							            		<div class="row">
							            			<div class="col-md-5 col-md-offset-1">
							            				<label>Hobbies</label>
							            				<textarea class="form-control" id="hobby" cols="2" placeholder="Hobbies"></textarea>
							            			</div>
							            			<div class="col-md-5">
							            				<label>Skills</label>
							            				<textarea class="form-control" id="skill" cols="2" placeholder="Skills"></textarea>
							            			</div>
							            		</div>
							            	</div>
							            	<div class="form-group">
							            		<button class="btn btn-primary pull-right" id="btnPersonalInformationSave">SAVE</button>
							            	</div>
		                    			</form>
									</div>
								</div>
		                    </div>
		                    <div class="tab-pane" role="tabpanel" id="step2">
		                    	<div class="box box-primary">
		                    		<div class="box-body">
	                    				<div class="col-md-5 col-md-offset-1">
	                    					<form id="formImage" enctype="multipart/form-data" role="form" method="POST" action="{{ route('applicant-picture-save') }}">
												<h3>PROFILE IMAGE</h3>
												<div class="form-group">
													<img id="pictureview" src="/applicant/default.png" alt="IMAGE" style="width: 50%; height: 50%;" class="center-block">
												</div>
												<div class="form-group">
													<div class="column">
														<div class="col-md-11 no-padding">
															<input type="file" class="form-control" name="picture" id="picture" accept="image/*" data-type='image'>
														</div>
														<div class="col-md-1 no-padding">
															<button class="btn btn-primary pull-right" id="btnImageSave">SAVE</button>
														</div>
													</div>
												</div>
												<input type="hidden" name="_token" value="{{ Session::token() }}">
											</form>
	                    				</div>
			                    		<div class="col-md-5">
			                    			<form id="formAccount" data-parsley-validate>
			                    				<h3>ACCOUNT INFORMATION</h3>
				                    			<div class="form-group">
				                        			<label>New Username *</label>
				                        			<input type="text" class="form-control" id="username" placeholder="Username" required>	
				                        		</div>
								            	<div class="form-group">
								            		<label>New Password *</label>
				                        			<input type="password" class="form-control input-password" id="password" placeholder="Password" required>
								            	</div>
								            	<div class="form-group">
								            		<label>Confirm Password *</label>
				                        			<input type="password" class="form-control input-confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
								            	</div>
								            	<div class="form-group">
				                        			<button class="btn btn-primary pull-right" id="btnIDsSave">SAVE</button>
				                        		</div>
				                    		</form>
			                    		</div>
									</div>
								</div>
		                    </div>
		                    <div class="tab-pane" role="tabpanel" id="step3">
		                    	<div class="box box-primary">
		                    		<div class="box-body">
		                    			<form id="formIDs" data-parsley-validate>
		                    				<div class="col-md-offset-1">
			                    				<h3>IDs</h3>
			                    			</div>
			                    			<div class="form-group">
			                        			<div class="row">
			                        				<div class="col-md-3 col-md-offset-1">
			                        					<label>Security Guard License *</label>
			                        					<input type="text" class="form-control" id="license" placeholder="AAA99999999999" data-inputmask="'mask': 'aaa99999999999'" pattern="([a-zA-Z]{3})(\d{11})" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>License Expiration *</label>
			                        					<input type="text" class="form-control mydatepicker" id="licenseexpiration" placeholder="yyyy-mm-dd" required>
			                        				</div>
			                        			</div>
			                        		</div>
			                        		<div class="form-group">
			                        			<div class="row">
			                        				<div class="col-md-2 col-md-offset-1">
			                        					<label>SSS *</label>
			                        					<input type="text" class="form-control" id="sss" placeholder="99-9999999-9" data-inputmask="'mask': '99-9999999-9'" pattern="(\d{2})-(\d{7})-(\d{1})" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>PHILHEALTH *</label>
			                        					<input type="text" class="form-control" id="philhealth" placeholder="99-999999999-9" data-inputmask="'mask': '99-999999999-9'" pattern="(\d{2})-(\d{9})-(\d{1})" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>PAGIBIG *</label>
			                        					<input type="text" class="form-control" id="pagibig" placeholder="9999-9999-9999" data-inputmask="'mask': '9999-9999-9999'" pattern="(\d{4})-(\d{4})-(\d{4})" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>TIN *</label>
			                        					<input type="text" class="form-control" id="tin" placeholder="999-999-999-999" data-inputmask="'mask': '999-999-999-999'" pattern="(\d{3})-(\d{3})-(\d{3})-(\d{3})" required>
			                        				</div>
			                        			</div>
			                        		</div><hr>
			                        		<div class="col-md-offset-1">
			                        			<h3>CONTACT PERSON</h3>
			                        		</div>
			                        		<div class="form-group">
			                        			<div class="row">
			                        				<div class="col-md-6 col-md-offset-1">
			                        					<label>Contact Person *</label>
			                        					<input type="text" class="form-control" id="contactperson" placeholder="Contact Person" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>Mobile # *</label>
			                        					<input type="text" class="form-control" id="contactno" placeholder="Mobile #" data-inputmask="'mask': '+63 999 9999 999'" required>
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>Telephone #</label>
			                        					<input type="text" class="form-control" id="contacttelno" placeholder="Telephone #" data-inputmask="'mask': '(99) 999 9999'">
			                        				</div>
			                        			</div>
			                        		</div>
			                        		<div class="spouse-info" style="display: none;"><hr>
			                        			<div class="col-md-offset-1">
			                        				<h3>SPOUSE</h3>
			                        			</div>
			                        			<div class="row">
			                        				<div class="col-md-5 col-md-offset-1">
			                        					<label>Name</label>
			                        					<input type="text" class="form-control" id="spousename" placeholder="Name">
			                        				</div>
			                        				<div class="col-md-2">
			                        					<label>Birthdate</label>
			                        					<input type="text" class="form-control mydatepicker" id="spousebirthdate" placeholder="yyyy-mm-dd">
			                        				</div>
			                        				<div class="col-md-3">
			                        					<label>Occupation</label>
			                        					<input type="text" class="form-control" id="spouseoccupation" placeholder="Occupation">
			                        				</div>
			                        			</div>
			                        		</div>
			                        		<div class="form-group">
			                        			<button class="btn btn-primary pull-right" id="btnIDsSave">SAVE</button>
			                        		</div>
		                    			</form>
									</div>
								</div>
		                    </div>
		                    <div class="tab-pane" role="tabpanel" id="step4">
		                        <div class="box box-primary">
		                    		<div class="box-body">
		                    			<div class="box box-primary">
		                        			<div class="box-header with-border">
		                        				<h3 class="box-title">EDUCATION BACKGROUND *</h3>
		                        				<div class="box-tools pull-right">
		                        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                        				</div>
		                        			</div>
		                        			<div class="box-body">
		                        				<form id="formEducationBackground" data-parsley-validate>
									            	<div class="form-group">
									            		<div class="row">
									            			<div class="col-md-8">
									            				<label>School Graduated</label>
									            				<input type="text" class="form-control" id="ebSchoolGraduated" placeholder="School Graduated" required>
									            			</div>
									            			<div class="col-md-4">
									            				<label>Graduate Type</label>
									            				<select class="form-control" id="ebGraduateType">
										              				<option value="Elementary">Elementary</option>
										              				<option value="High School">High School</option>
										              				<option value="College">College</option>
										              				<option value="Vocational">Vocational</option>
										              			</select>
									            			</div>
									            		</div>
									            	</div>
									            	<div class="form-group">
									            		<div class="row">
									            			<div class="col-md-3">
									            				<label>Date Graduated</label>
									            				<input type="text" class="form-control mydatepicker" id="ebDateGraduated" placeholder="yyyy-mm-dd" required>
									            			</div>
									            			<div class="col-md-8">
									            				<div class="degree-info" style="display: none;">
									            					<label>Degree</label>
									            					<input type="text" class="form-control" id="ebDegree" placeholder="Degree">
									            				</div>
									            			</div>
									            			<div class="col-md-1">
									            				<input type="submit" class="btn btn-primary pull-right"  id="btnAddEducationBackground" value="ADD">
									            			</div>
									            		</div>
									            	</div>
									            	<table class="table table-striped table-bordered" id="tblEducationBackground">
														<thead>
															<th>Graduate Type</th>
															<th>Degree</th>
															<th>Date Graduated</th>
															<th>School Graduated</th>
															<th style="text-align: center;">Action</th>
														</thead>
														<tbody id="education-list"></tbody>
													</table>
												</form>
		                        			</div>
		                        		</div>
		                        		<div class="box box-primary collapsed-box">
		                        			<div class="box-header with-border">
		                        				<h3 class="box-title">EMPLOYMENT RECORD</h3>
		                        				<div class="box-tools pull-right">
		                        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                        				</div>
		                        			</div>
		                        			<div class="box-body">
		                        				<form id="formEmploymentRecord" data-parsley-validate>
									            	<div class="form-group">
									            		<div class="row">
									            			<div class="col-md-9">
									            				<label>Company Name</label>
									            				<input type="text" class="form-control" id="erCompany" placeholder="Company Name" required>
									            			</div>
									            			<div class="col-md-3">
									            				<label>Industry Type</label>
									            				<select class="form-control" id="erIndustryType" required>
									            					<option value="Church">Church</option>
									            					<option value="Mall">Mall</option>
									            					<option value="Park">Park</option>
									            					<option value="School">School</option>
									            				</select>
									            			</div>
									            		</div>
									            	</div>
									            	<div class="form-group">
									            		<div class="row">
									            			<div class="col-md-3">
									            				<label>Duration</label>
									            				<div class="column">
									            					<div class="col-md-6 no-padding">
									            						<input type="text" class="form-control" id="erDuration" style="text-align: right;" placeholder="Duration" pattern="^[1-9][0-9]*$" required>
									            					</div>
									            					<div class="col-md-6 no-padding">
									            						<select class="form-control" id="durationtype">
												              				<option value="day">day(s)</option>
												              				<option value="month">month(s)</option>
												              				<option value="year">year(s)</option>
												              			</select>
									            					</div>
									            				</div>
									            			</div>
									            			<div class="col-md-8">
									            				<label>Reason For Leaving</label>
									            				<input type="text" class="form-control" id="erReason" placeholder="Reason For Leaving">
									            			</div>
									            			<div class="col-md-1">
									            				<input type="submit" class="btn btn-primary pull-right"  id="btnAddEmploymentRecord" value="ADD">
									            			</div>
									            		</div>
									            	</div>
									            	<table class="table table-striped table-bordered" id="tblEmploymentRecord">
														<thead>
															<th>Company</th>
															<th>Industry Type</th>
															<th>Duration (months)</th>
															<th>Reason For Leaving</th>
															<th style="text-align: center;">Action</th>
														</thead>
														<tbody id="employment-list"></tbody>
													</table>
										        </form>
		                        			</div>
		                        		</div>
		                        		<div class="box box-primary collapsed-box">
		                        			<div class="box-header with-border">
		                        				<h3 class="box-title">TRAINING CERTIFICATE</h3>
		                        				<div class="box-tools pull-right">
		                        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		                        				</div>
		                        			</div>
		                        			<div class="box-body">
		                        				<form id="formTrainingCertificate" data-parsley-validate>
									            	<div class="form-group">
											            <div class="row">
											            	<div class="col-md-9">
											            		<label>Training Certificate</label>
											            		<input type="text" class="form-control" id="tcCertificate" placeholder="Training Certificate" required>
											            	</div>
											            	<div class="col-md-3">
											            		<label>Date Conducted</label>
											            		<input type="text" class="form-control mydatepicker" id="tcDateConducted" placeholder="yyyy-mm-dd" required>
											            	</div>						            	
											            </div>
									            	</div>
									            	<div class="form-group">
									            		<div class="row">
									            			<div class="col-md-11">
									            				<label>Conducted By</label>
									            				<input type="text" class="form-control" id="tcConductedBy" placeholder="Conducted By" required>
									            			</div>
									            			<div class="col-md-1">
									            				<input type="submit" class="btn btn-primary pull-right"  id="btnAddTrainingCertificate" value="ADD">
									            			</div>
									            		</div>
									            	</div>
									            	<table class="table table-striped table-bordered" id="tblTrainingCertificate">
														<thead>
															<th>Certificate</th>
															<th>Conducted By</th>
															<th>Date Conducted</th>
															<th style="text-align: center;">Action</th>
														</thead>
														<tbody id="training-list"></tbody>
													</table>
										        </form>
		                        			</div>
		                        		</div>
			                        </div>
								</div>
		                    </div>
		                </div>
			        </div><hr>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								 <h3>LIST OF REQUIREMENTS</h3>
								 <table id="tblRequirement" class="table table-striped table-bordered">
									<thead>
										<th>Credentials</th>
										<th style="text-align: center;">Action</th>
									</thead>
									<tbody id="requirement-list"></tbody>
								</table>
							</div>
							<div class="col-md-6">
								<h3>PASSED</h3>
								<table id="tblPass" class="table table-striped table-bordered">
									<thead>
										<th>Credentials</th>
										<th style="text-align: center;">Action</th>
									</thead>
									<tbody id="pass-list"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnSave">SAVE</button>
        				<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/transaction/submitcredential.js"></script>
@endsection