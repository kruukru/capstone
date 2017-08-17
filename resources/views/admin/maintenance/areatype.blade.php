@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - Area Type</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New Area Type</button><hr>
						<table id="tblAreaType" class="table table-striped table-bordered">
							<thead>
								<th>Area Type</th>
								<th>Amount Per Hour</th>
								<th>Description</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="areatype-list">
								@foreach ($areatypes as $areatype)
								<tr id="id{{$areatype->areatypeid}}">
									<td>{{$areatype->name}}</td>
									<td>{{$areatype->amountperhour}}</td>
									<td>{{$areatype->description}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$areatype->areatypeid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$areatype->areatypeid}}">Remove</button>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- modal for new and update -->
	<div class="modal fade" id="modalAreaType">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formAreaType" data-parsley-validate>
				<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Area Type *</label>
							<input type="text" id="inputAreaType" class="form-control" maxlength="100" required>
						</div>
						<div class="form-group">
							<label>Amount Per Hour *</label>
							<div class="input-group">
								<span class="input-group-addon"><i>&#8369;</i></span>
								<input type="text" id="inputAreaTypeAmountPerHour" class="form-control" style="text-align: right;" required>
							</div>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea id="inputAreaTypeDescription" rows="3" class="form-control"></textarea>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button id="btnSave" value="New" class="btn btn-primary">SAVE</button>
	        				<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalAreaTypeRemove">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to remove this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnRemoveConfirm">CONFIRM</button>
        			<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('meta')
	<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
	<script src="/js/custom/admin/maintenance/areatype.js"></script>
@endsection