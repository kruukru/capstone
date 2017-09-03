@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<h3>Notification</h3>
					<table id="tblNotification" class="table table-striped table-bordered">
						<thead>
							<th>Description</th>
							<th>Topic</th>
							<th>Priority</th>
						</thead>
						<tbody id="notification-list">
							@foreach ($notifications as $notification)
							<tr>
								<td>
									@if ($notification["priority"] == 1)
									<i class="fa fa-warning text-red"></i>
									@else
									<i class="fa fa-warning text-yellow"></i>
									@endif
									{{$notification["description"]}}
								</td>
								<td>{{$notification["topic"]}}</td>
								<td>{{$notification["priority"]}}</td>
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
<script src="/js/custom/admin/home.js"></script>
@endsection