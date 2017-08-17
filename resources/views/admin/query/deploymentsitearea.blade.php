@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query - Deployment Site Area</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblClient" class="table table-striped table-bordered">
							<thead>
								<th>Province</th>
								<th>City</th>
								<th style="text-align: right;"># of Deployment Site</th>
							</thead>
							<tbody>
								@foreach ($deploymentsites as $deploymentsite)
								<tr>
									<td>{{$deploymentsite->province}}</td>
									<td>{{$deploymentsite->city}}</td>
									<td style="text-align: right;">{{$deploymentsite->total}}</td>
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
	<script src="/js/custom/admin/query/deploymentsitearea.js"></script>
@endsection