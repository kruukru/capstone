@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Inventory</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-6">
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
										<button class="btn btn-primary btn-xs" id="btnAdd" value="{{$item->itemid}}">Add</button>
										@if (strtoupper($item->itemtype->name) != "FIREARM" && strtoupper($item->itemtype->name) != "FIREARMS")
											<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$item->itemid}}">Remove</button>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="container col-sm-6">
				<div class="box box-primary">
					<div class="box-header with-border">
        				<h3 class="box-title">FIREARMS</h3>
        				<div class="box-tools pull-right">
        					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        				</div>
        			</div>
					<div class="box-body table-responsive">
						<table id="tblFirearmInventory" class="table table-striped table-bordered">
							<thead>
								<th>Name</th>
								<th>License</th>
								<th>Expiration</th>
								<th>Status</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="firearminventory-list">
								@foreach ($firearms as $firearm)
								<tr id="id{{$firearm->firearmid}}">
									<td>{{$firearm->item->name}}</td>
									<td>{{$firearm->license}}</td>
									<td>{{$firearm->expiration->format('Y-m-d')}}</td>
									<td style="text-align: center;">
										@if ($firearm->issuedfirearm)
											DEPLOYED
										@elseif ($firearm->expiration <= Carbon\Carbon::today())
											EXPIRED
										@else
											AVAILABLE
										@endif
									</td>
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs" id="btnUpdate" value="{{$firearm->firearmid}}">Update</button>
										<button class="btn btn-danger btn-xs" id="btnRemove" value="{{$firearm->firearmid}}">Remove</button>
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
						<h3>Add Item</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Quantity <span class="asterisk-red">*</span></label>
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

	<div class="modal fade" id="modalRemoveItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formRemoveItem" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Remove Item</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<label>Quantity <span class="asterisk-red">*</span></label>
							<input type="text" id="inputRemoveQuantity" class="form-control" maxlength="5" pattern="^[1-9][0-9]*$" required>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button class="btn btn-primary" id="btnSaveRemoveItem">SAVE</button>
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
						<h3>Add Firearm</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<label>License <span class="asterisk-red">*</span></label>
									<input type="text" id="inputFirearmLicense" class="form-control" placeholder="A99AA9999999" data-inputmask="'mask': 'a99aa9999999'" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<label>Expiration <span class="asterisk-red">*</span></label>
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

	<div class="modal fade" id="modalUpdateFirearm">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="formUpdateFirearm" data-parsley-validate>
					<!-- modal header -->
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h3>Update Firearm</h3>
					</div>
					<!-- modal body -->
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Name:</label>
										<h4 id="firearmname"></h4>
									</div>
									<div class="form-group">
										<label>Firearm License:</label>
										<h4 id="firearmlicense"></h4>
									</div>
								</div>
								<div class="col-md-6">
									<label>Expiration <span class="asterisk-red">*</span></label>
									<input type="text" id="inputUpdateFirearmExpiration" class="form-control mydatepicker" placeholder="yyyy-mm-dd" required>
								</div>
							</div>
						</div>
					</div>
					<!-- modal footer -->
					<div class="modal-footer">
						<button class="btn btn-primary" id="btnSaveUpdateFirearm">SAVE</button>
	        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalRemoveFirearm">
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
	<script src="/js/custom/admin/transaction/inventory.js"></script>
@endsection