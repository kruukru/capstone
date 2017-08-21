@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query - Security Guard Vacant</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
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
		</div>
	</section>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/query/securityguardvacant.js"></script>
@endsection