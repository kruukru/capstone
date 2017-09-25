@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Inventory</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblInventory" class="table table-striped table-bordered">
							<thead>
								<th>Item</th>
								<th>Item Type</th>
								<th style="text-align: right;">Quantity</th>
								<th style="text-align: right;">Quantity Available</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="item-list">
								@foreach ($items as $item)
								<tr id="id{{$item->itemid}}">
									<td>{{$item->name}}</td>
									<td id="itemtype">{{$item->itemtype->name}}</td>
									<td style="text-align: right;">{{$item->qty}}</td>
									<td style="text-align: right;">{{$item->qtyavailable}}</td>
									<td style="text-align: center;">
										<button class="btn btn-success btn-xs" id="btnAdd" value="{{$item->itemid}}">Add</button>
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

	<!-- modal for add -->
	<div class="modal fade" id="modalItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formItem" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Add Item</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Quantity *</label>
							<input type="text" id="inputQuantity" class="form-control" maxlength="5" pattern="^[1-9][0-9]*$" required>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button class="btn btn-primary" id="btnSaveItem">SAVE</button>
	        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- modal add for firearm -->
	<div class="modal fade" id="modalFirearm">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formFirearm" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h4>Add Firearm</h4>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<label>License *</label>
									<input type="text" id="inputFirearmLicense" class="form-control" placeholder="A99AA9999999" data-inputmask="'mask': 'a99aa9999999'" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<label>Expiration *</label>
									<input type="text" id="inputFirearmExpiration" class="form-control mydatepicker" placeholder="yyyy-mm-dd" required>
								</div>
								<div class="col-md-2 col-md-offset-3">
									<button class="btn btn-primary" id="btnAddFirearm">ADD</button>
								</div>
							</div>
						</div><hr>
						<div class="form-group table-responsive">
							<table id="tblFirearm" class="table table-striped table-bordered">
								<thead>
									<th>License</th>
									<th>Expiration</th>
									<th style="text-align: center;">Action</th>
								</thead>
								<tbody id="firearm-list"></tbody>
							</table>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button class="btn btn-primary" id="btnSaveFirearm">SAVE</button>
	        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
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
	<script src="/js/custom/admin/transaction/inventory.js"></script>
@endsection