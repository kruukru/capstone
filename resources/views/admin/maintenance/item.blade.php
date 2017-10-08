@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Maintenance - Item</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
					<button id="btnNew" class="btn btn-primary btn-md">New Item</button><hr>
						<table id="tblItem" class="table table-striped table-bordered">
							<thead>
								<th>Item</th>
								<th>Item Type</th>
								<th>Description</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="item-list">
								@foreach ($items as $item)
								<tr id="id{{$item->itemid}}">
									<td>{{$item->name}}</td>
									<td>{{$item->itemtype->name}}</td>
									<td>{{$item->description}}</td>
									<td style="text-align: center;">
										<button class="btn btn-warning btn-xs" id="btnUpdate" value="{{$item->itemid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$item->itemid}}">Remove</button>
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
	<div class="modal fade" id="modalItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formItem" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3 id="modalTitle">XXX</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
							<div class="form-group">
								<label>Item <span class="asterisk-red">*</span></label>
								<input type="text" id="inputItem" class="form-control" maxlength="100" required>
							</div>
							<div class="form-group">
								<label>Item Type <span class="asterisk-red">*</span></label>
								<select id="inputItemType" class="form-control" required></select>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea id="inputItemDescription" rows="3" class="form-control"></textarea>
							</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<div class="form-group">
							<button id="btnSave" value="New" class="btn btn-primary">SAVE</button>
	    					<button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal for remove -->
	<div class="modal fade" id="modalItemRemove">
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
	<script src="/js/custom/admin/maintenance/item.js"></script>
@endsection