@extends(Auth::user()->accounttype == 10 ? 'client.templates.default' : 'manager.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-android-unlock"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">NUBMER OF DEPLOYMENT SITES</span>
						<h3>{{$deploymentsite->count()}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-person-stalker"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">NUMBER OF SECURITY GUARDS</span>
						<h3>{{$applicant->count()}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
		</div>
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<div class="col-md-6">
						<h3>SECURITY GUARDS WITH MOST NUMBER OF ABSENT</h3>
						<table id="tblAbsent" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th># of Absent</th>
							</thead>
							<tbody>
								@foreach ($absents as $absent)
									<tr>
										<td>{{$absent->firstname}} {{$absent->middlename}} {{$absent->lastname}}</td>
										<td>{{$absent->attendance->count()}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<h3>SECURITY GUARDS WITH MOST NUMBER OF LATE</h3>
						<table id="tblLate" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th># of Late</th>
							</thead>
							<tbody>
								@foreach ($lates as $late)
									<tr>
										<td>{{$late->firstname}} {{$late->middlename}} {{$late->lastname}}</td>
										<td>{{$late->attendance->count()}}</td>
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
<script src="/js/custom/client/dashboard.js"></script>
@endsection