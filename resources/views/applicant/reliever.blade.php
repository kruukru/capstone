@extends('applicant.templates.default')

@section('content')
@if (Auth::user()->applicant->status == 11)
<section class="content-header">
	<h1>Reliever</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title">DEPLOYMENT SITE DETAILS</h3>
    			</div>
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Company Name:</label>
									<h4>&emsp;{{$deploymentsite->contract->client->company}}</h4>
								</div>
								<div class="form-group">
									<label>Address:</label>
									<h4>&emsp;{{$deploymentsite->contract->client->address}}</h4>
								</div>
								<div class="form-group">
									<label>Contact Person:</label>
									<h4>&emsp;{{$deploymentsite->contract->client->firstname}} {{$deploymentsite->contract->client->middlename}} {{$deploymentsite->contract->client->lastname}}</h4>
								</div>
								<div class="form-group">
									<label>Contact #:</label>
									<h4>&emsp;{{$deploymentsite->contract->client->contactpersonno}}</h4>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Site Name:</label>
									<h4>&emsp;{{$deploymentsite->sitename}}</h4>
								</div>
								<div class="form-group">
									<label>Location:</label>
									<h4>&emsp;{{$deploymentsite->location}}</h4>
								</div>
								<div class="form-group">
									<label>Date:</label>
									<h4>&emsp;{{$reliever->date->format('F d, Y')}}</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/applicant/reliever.js"></script>
@endsection