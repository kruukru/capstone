@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-list-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">UNSCHEDULED APPLICANTS</span>
		              	<span class="info-box-number">{{$unscheduledapplicants}}</span>
		            </div>
		        </div>
			</div>
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-copy-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">ON APPOINTMENT</span>
		              	<span class="info-box-number">{{$onappointment}}</span>
		            </div>
		        </div>
			</div>
		    <div class="col-md-6">
		    	<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-paper-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">TESTING AND INTERVIEW</span>
		              	<span class="info-box-number">{{$testingandinterview}}</span>
		            </div>
		        </div>
		    </div>
		    <div class="col-md-6">
		    	<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-bookmarks-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">INCOMPLETE CREDENTIALS</span>
		              	<span class="info-box-number">{{$incompletecredentials}}</span>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">SECURITY GUARDS</h3>
				</div>
				<div class="box-body table-responsive">
					<div class="col-md-6">
						<h4>Status</h4>
						<canvas id="sgstatus"></canvas>
					</div>
					<div class="col-md-6">
						<h4>Priority for Deployment</h4>
						<canvas id="sgpriority"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<div class="col-md-6">
						<h3>EXPIRING SECURITY GUARD LICENSE</h3>
						<table id="tblLicense" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th>License</th>
								<th>Expiration</th>
							</thead>
							<tbody>
								@foreach ($applicants as $applicant)
								<tr>
									<td>{{$applicant->firstname}} {{$applicant->middlename}} {{$applicant->lastname}}</td>
									<td>{{$applicant->license}}</td>
									<td>{{$applicant->licenseexpiration->format('Y-m-d')}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<h3>REQUESTS</h3>
						<table id="tblRequest" class="table table-striped table-bordered">
							<thead>
								<th>Request No.</th>
								<th>Company Name</th>
								<th>Deployment Site</th>
							</thead>
							<tbody>
								@foreach ($requests as $request)
								<tr>
									<td>{{$request->requestid}}</td>
									<td>{{$request->account->client->company}}</td>
									<td>{{$request->deploymentsite->sitename}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/admin/hrhome.js"></script>
@endsection