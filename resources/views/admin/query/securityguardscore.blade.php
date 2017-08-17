@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query - Security Guard Score</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th style="text-align: right;">Test Item</th>
								<th style="text-align: right;">Test Score</th>
								<th style="text-align: center;">Percent</th>
							</thead>
							<tbody>
								@foreach ($scores as $score)
								<tr>
									<td>{{$score->applicant->lastname}}, {{$score->applicant->firstname}} {{$score->applicant->middlename}}</td>
									<td style="text-align: right;">{{$score->item}}</td>
									<td style="text-align: right;">{{$score->score}}</td>
									<td style="text-align: center;">{{number_format(($score->score / $score->item) * 100, 2, '.', ',')}}%</td>
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
	<script src="/js/custom/admin/query/securityguardscore.js"></script>
@endsection