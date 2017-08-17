@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query - Client Contract</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblClient" class="table table-striped table-bordered">
							<thead>
								<th>Client Name</th>
								<th>Contact Person</th>
								<th>Contact Person #</th>
								<th style="text-align: right;"># of Contract</th>
							</thead>
							<tbody>
								@foreach ($clients as $client)
								<tr>
									<td>{{$client->name}}</td>
									<td>{{$client->contactperson}}</td>
									<td>{{$client->contactpersonno}}</td>
									<td style="text-align: right;">{{$client->contract->count()}}</td>
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
	<script src="/js/custom/admin/query/clientcontract.js"></script>
@endsection