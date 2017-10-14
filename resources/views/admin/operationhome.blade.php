@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-person-add"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">REQUEST FOR PERSONNEL</span>
						<h3>{{$requestforpersonnel}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
			<div class="col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-tshirt-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">REQUEST FOR ITEM</span>
						<h3>{{$requestforitem}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
		    <div class="col-md-4">
		    	<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-clipboard"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">NUMBER OF REPORTS</span>
						<h3>{{$numberofreport}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
		    </div>
		</div>
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<div class="col-md-6">
						<h3>RECENTLY ISSUED CERTIFICATE</h3>
						<table id="tblRecentlyCertificate" class="table table-striped table-bordered">
							<thead>
								<th>Subject</th>
								<th>Place Happen</th>
								<th>Detail</th>
								<th>Time</th>
							</thead>
							<tbody>
								@foreach ($certificates as $certificate)
									<tr>
										<td>{{$certificate->subject}}</td>
										<td>{{$certificate->placehappen}}</td>
										<td>{{$certificate->detail}}</td>
										<td>{{$certificate->created_at->diffForHumans()}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<h3>RECENTLY ISSUED MEMORANDUM</h3>
						<table id="tblRecentlyMemorandum" class="table table-striped table-bordered">
							<thead>
								<th>Subject</th>
								<th>Place Happen</th>
								<th>Detail</th>
								<th>Time</th>
							</thead>
							<tbody>
								@foreach ($memorandums as $memorandum)
									<tr>
										<td>{{$memorandum->subject}}</td>
										<td>{{$memorandum->placehappen}}</td>
										<td>{{$memorandum->detail}}</td>
										<td>{{$memorandum->created_at->diffForHumans()}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
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
	</div>
</section>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/admin/dashboard.js"></script>
@endsection