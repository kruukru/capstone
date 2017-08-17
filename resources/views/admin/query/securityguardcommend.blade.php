@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Query - Security Guard Commend</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblSecurityGuard" class="table table-striped table-bordered">
							<thead>
								<th>Security Guard Name</th>
								<th style="text-align: right;"># of Commend</th>
							</thead>
							<tbody>

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
	<script src="/js/custom/admin/query/securityguardcommend.js"></script>
@endsection