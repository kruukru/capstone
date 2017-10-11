@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Report</h1>
	</section>

	<section class="content">
		<div class="row">
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary">
						<form id="formFirearmLicense" role="form" method="GET" action="{{ route('admin-report-firearmlicense') }}">
							<div class="box-header with-border">
		        				<h3 class="box-title">FIREARM LICENSE</h3>
		        				<div class="box-tools pull-right">
		        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		        				</div>
		        			</div>
							<div class="box-body table-responsive">
								<div class="form-group">
									<label>Deployment Site</label>
									<select class="form-control" id="firearmdeploymentsiteid" name="firearmdeploymentsiteid">
										<option value="none">None</option>
										@foreach ($deploymentsites as $deploymentsite)
											<option value="{{$deploymentsite->deploymentsiteid}}">{{$deploymentsite->sitename}}, {{$deploymentsite->location}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Date Range</label>
									<div class="input-group">
										<button type="button" class="btn btn-default" id="btnDateRangeFirearm">
											<span></span>&ensp;<i class="fa fa-caret-down"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<div class="form-group">
									<input type="hidden" id="firearmstartdate" name="firearmstartdate">
									<input type="hidden" id="firearmenddate" name="firearmenddate">
									<button type="submit" class="btn btn-primary pull-right" id="btnGenerateFirearm">GENERATE</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">SECURITY LICENSE</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">EQUIPMENT</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">DUTY DETAIL ORDER</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							
						</div>
					</div>
				</div>
			@endif
			@if (Auth::user()->accounttype == 0)
				<div class="container col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
	        				<h3 class="box-title">MONTHLY DISPOSITION REPORT</h3>
	        				<div class="box-tools pull-right">
	        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
	        				</div>
	        			</div>
						<div class="box-body table-responsive">
							
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
	<script src="/js/custom/admin/report/report.js"></script>
@endsection