@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Notification</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table id="tblNotification" class="table table-striped table-bordered">
						<thead>
							<th>Description</th>
							<th>Topic</th>
							<th>Priority</th>
						</thead>
						<tbody id="notification-list">
							@foreach ($notifs as $notif)
							<tr>
								<td>
									<i class="fa fa-warning {{$notif['priority'] == 1 ? 'text-red' : 'text-yellow'}} text-red"></i> {{$notif["description"]}}
								</td>
								<td>{{$notif["topic"]}}</td>
								<td>{{$notif["priority"]}}</td>
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
<script src="/js/custom/admin/notification.js"></script>
@endsection