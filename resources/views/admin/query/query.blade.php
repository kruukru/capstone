@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query</h1>
	</section>

	<section class="content">
		<div class="row">
			@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 3)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">HIGHEST SCORERS</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblSecurityGuardScore" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th style="text-align: right;">Test Item</th>
									<th style="text-align: right;">Test Score</th>
									<th style="text-align: center;">Percent</th>
								</thead>
								<tbody>
									@foreach ($scores as $score)
										@if ($score->item != 0)
											<tr>
												<td>{{$score->applicant->lastname}}, {{$score->applicant->firstname}} {{$score->applicant->middlename}}</td>
												<td style="text-align: right;">{{$score->item}}</td>
												<td style="text-align: right;">{{$score->score}}</td>
												<td style="text-align: center;">{{number_format(($score->score / $score->item) * 100, 2, '.', ',')}}%</td>
											</tr>
										@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 3)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">SECURITY GUARD WAITING LIST</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblSecurityGuardVacant" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th style="text-align: right;">Vacant in day(s)</th>
								</thead>
								<tbody>
									@foreach ($applicants as $applicant)
									<tr>
										<td>{{$applicant->lastname}}, {{$applicant->firstname}} {{$applicant->middlename}}</td>
										<td style="text-align: right;">{{$applicant->lastdeployed->diffInDays(Carbon\Carbon::today())}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 2)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">SECURITY GUARD WITH MOST NUMBER OF COMMENDS</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblSecurityGuardCommend" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th style="text-align: right;"># of Commend</th>
								</thead>
								<tbody>
									@foreach ($commends as $commend)
									<tr>
										<td>{{$commend['name']}}</td>
										<td style="text-align: right;">{{$commend['count']}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 2)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">SECURITY GUARD WITH MOST NUMBER OF VIOLATIONS</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblSecurityGuardViolation" class="table table-striped table-bordered">
								<thead>
									<th>Security Guard Name</th>
									<th style="text-align: right;"># of Violation</th>
								</thead>
								<tbody>
									@foreach ($violations as $violation)
									<tr>
										<td>{{$violation['name']}}</td>
										<td style="text-align: right;">{{$violation['count']}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">CLIENT WITH MOST NUMBER OF CONTRACTS</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblClientContract" class="table table-striped table-bordered">
								<thead>
									<th>Client Name</th>
									<th>Contact Person</th>
									<th>Contact Person #</th>
									<th style="text-align: right;"># of Contract</th>
								</thead>
								<tbody>
									@foreach ($clientcontracts as $clientcontract)
									<tr>
										<td>{{$clientcontract->company}}</td>
										<td>{{$clientcontract->lastname}}, {{$clientcontract->firstname}} {{$clientcontract->middlename}}</td>
										<td>{{$clientcontract->contactpersonno}}</td>
										<td style="text-align: right;">{{$clientcontract->contract->count()}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 2)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">AREA WITH MOST DEPLOYMENT SITE</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							<table id="tblDeploymentSiteArea" class="table table-striped table-bordered">
								<thead>
									<th>Province</th>
									<th>City</th>
									<th style="text-align: right;"># of Deployment Site</th>
								</thead>
								<tbody>
									@foreach ($deploymentsiteareas as $deploymentsitearea)
									<tr>
										<td>{{$deploymentsitearea->province}}</td>
										<td>{{$deploymentsitearea->city}}</td>
										<td style="text-align: right;">{{$deploymentsitearea->total}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
		</div>
	</section>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/query/query.js"></script>
@endsection