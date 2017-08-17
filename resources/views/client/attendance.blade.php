@extends('client.templates.default')

@section('content')
	<section class="content-header">
		<h1>Attendance</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<!-- <a href="#"><button style="float: left;" id="btnNew" class="btn btn-primary btn-md">Deploy</button></a>
						<form id="formSearch" data-parsley-validate>
							<div class="input-group input-group-sm pull-right" style="width: 300px;">
								<input type="text" id="search" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" id="btnSearch"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</form> -->
						<table class="table table-striped">
							<thead>
								<th>Deploy Site</th>
								<th>Location</th>
								<th style="float: right; padding-right: 25px;">Action</th>
							</thead>
							<tbody id="deploy-list">
								<td>5J Store</td>
								<td>1326 Masinop St. Tondo Manila</td>
								<td style="float: right;"><button class="btn btn-primary btn-xs" id="btnAttendance" value="test">Attendance</button></td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for update client -->
	<div class="modal fade" id="modalAttendance">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formAttendance" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Attendance</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Security Guard Name:</label>
							<h3>Juan, Tamad</h3>
						</div>
						<div class="form-group">
							<label><input type="radio" name="grp">Late     </label>
							<label><input type="radio" name="grp">Day Time     </label>
							<label><input type="radio" name="grp">Night Shift     </label>
						</div>
						<div class="form-group">
		            		<label>Time Worked</label>
			                  <input type="number" class="form-control" id="lastname" placeholder="Time Worked" required>
		            	</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<input type="submit" id="btnSubmit" class="btn btn-success" value="Next">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/client/attendance.js"></script>
@endsection