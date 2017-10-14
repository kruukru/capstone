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
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-list-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">REQUEST FOR PERSONNEL</span>
		              	<span class="info-box-number">{{$requestforpersonnel}}</span>
		            </div>
		        </div>
			</div>
			<div class="col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-ios-copy-outline"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">REQUEST FOR ITEM</span>
		              	<span class="info-box-number">{{$requestforitem}}</span>
		            </div>
		        </div>
			</div>
		    <div class="col-md-4">
		    	<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-clipboard"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">NUMBER OF REPORTS</span>
		              	<span class="info-box-number">{{$numberofreport}}</span>
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
	</div>
</section>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/admin/dashboard.js"></script>
@endsection