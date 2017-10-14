@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-12">
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-cube"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">LOWEST ITEM AVAILABILITY</span>
						<h3>{{$itemcollections->count()}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
			<div class="col-md-6">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="ion ion-close-circled"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">FIREARMS WITH EXPIRING LICENSE</span>
						<h3>{{$firearms->count()}}</h3>
		              	<!-- <span class="info-box-number"></span> -->
		            </div>
		        </div>
			</div>
		</div>
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<h3>LOWEST ITEM AVAILABILITY</h3>
					<table id="tblItemAvailability" class="table table-striped table-bordered">
						<thead>
							<th>Item</th>
							<th>Quantity</th>
							<th>Quantity Available</th>
							<th>Percentage</th>
						</thead>
						<tbody>
							@foreach ($itemcollections as $itemcollection)
								<tr>
									<td>{{$itemcollection['name']}}</td>
									<td>{{$itemcollection['qty']}}</td>
									<td>{{$itemcollection['qtyavailable']}}</td>
									<td>{{number_format($itemcollection['percent'], 2, '.', '')}}%</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					<h3>FIREARMS WITH EXPIRING LICENSE</h3>
					<table id="tblExpiringFirearm" class="table table-striped table-bordered">
						<thead>
							<th>Item Name</th>
							<th>License</th>
							<th>Expiration</th>
							<th style="text-align: center;">Status</th>
						</thead>
						<tbody>
							@foreach ($firearms as $firearm)
								<tr>
									<td>{{$firearm->item->name}}</td>
									<td>{{$firearm->license}}</td>
									<td>{{$firearm->expiration->format('F d, Y')}}</td>
									<td style="text-align: center;">{{$firearm->issuedfirearm ? "DEPLOYED" : "AVAILABLE"}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="container col-sm-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">SECURITY GUARDS</h3>
				</div>
				<div class="box-body table-responsive">
					<div class="col-md-6">
						<h4>Status</h4>
						<canvas id="sgstatus"></canvas>
					</div>
					<div class="col-md-6">
						<h4>Priority for Deployment</h4>
						<canvas id="sgpriority"></canvas>
					</div>
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
<script src="/js/custom/admin/dashboard.js"></script>
@endsection