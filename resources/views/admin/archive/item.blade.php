@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Archive - Item</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table id="tblItem" class="table table-striped table-borderd">
							<thead>
								<th>ID</th>
								<th>Item</th>
								<th>Description</th>
								<th>Removed At</th>
								<th style="text-align: center;">Action</th>
							</thead>
							<tbody id="item-list">
								@foreach ($items as $item)
								<tr id="id{{$item->itemid}}">
									<td>{{$item->itemid}}</td>
									<td>{{$item->name}}</td>
									<td>{{$item->description}}</td>
									<td>{{$item->deleted_at}}</td>
									<td style="text-align: center;">
										<button class="btn btn-success btn-xs" id="btnRestore" value="{{$item->itemid}}">Restore</button>
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

	<!-- modal for remove -->
	<div class="modal fade" id="modalItem">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you want to restore this?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnRestoreConfirm">CONFIRM</button>
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
	<script src="/js/custom/admin/archive/item.js"></script>
@endsection