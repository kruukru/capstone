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
					<table id="legend">
						<tr>
							<td style="padding-right: 20px;"><b>LEGEND:</b></td>
							<td class="leg red"></td>
							<td id="legName">NEED URGENT ATTENTION</td>
							<td class="leg yllw"></td>
							<td id="legName">WARNING</td>
						</tr>
					</table><br>
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

@section('css')
	<style type="text/css">
		.posi {
			font-weight: bolder;
			color: green;
		}
		.nega {
			font-weight: bolder;
			color: red;
		}
		#legend {
			padding: 10px;
			margin-top: 10px;
		}
		.leg {
			min-width: 30px;
		}
		.red {
			background-color: #ffbdbd;
		}
		.blue {
			background-color: #a9daff;
		}
		.grn {
			background-color: #b0f7be;
		}
		.yllw {
			background-color: #fffca9;
		}
		.orng {
			background-color: #ffeeba;
		}
		#legName {
			padding:5px 25px 5px 10px;
		}
	</style>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<script src="/js/custom/admin/notification.js"></script>
@endsection