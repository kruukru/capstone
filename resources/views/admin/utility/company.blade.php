@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Utility - Company Details</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-8" id="companydetails">
				<form id="formCompany" data-parsley-validate>
					<div class="box box-primary">
						<div class="box-body">
							<div class="form-group">
								<div class="row">
									<div class="col-md-9">
										<label>Name</label>
										<input type="text" class="form-control" id="name" value="{{$company->name}}" maxlength="100" required>
									</div>
									<div class="col-md-3">
										<label>Short Name</label>
										<input type="text" class="form-control" id="shortname" value="{{$company->shortname}}" maxlength="9" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea class="form-control" rows="2" id="address" required>{{$company->address}}</textarea>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-7">
										<label>LTO License</label>
										<input type="text" class="form-control" id="license" value="{{$company->license}}" data-inputmask="'mask': 'aaa-999999-9999'" pattern="([a-zA-Z]{3})-(\d{6})-(\d{4})" required>
									</div>
									<div class="col-md-5">
										<label>Expiration</label>
										<input type="text" class="form-control mydatepicker" id="expiration" value="{{$company->expiration}}" pattern="(\d{4})-(\d{2})-(\d{2})" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Contact No.</label>
								<input type="text" class="form-control" id="contactno" value="{{$company->contactno}}" required>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" id="email" value="{{$company->email}}" required>
							</div>
						</div>
						<div class="box-footer">
							<button class="btn btn-primary pull-right" id="btnSaveCompany">SAVE</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4" id="companylogo">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<div class="box-header">
							<h3 class="box-title">Logo</h3>
						</div>
						<form id="formImage" enctype="multipart/form-data" role="form" method="POST" action="">
							<div class="form-group">
								<img id="pictureview" src="/images/{{$company->logo}}" alt="IMAGE" style="width: 50%; height: 50%;" class="center-block">
							</div>
							<div class="form-group">
								<div class="column">
									<div class="col-md-11 no-padding">
										<input type="file" class="form-control" name="picture" id="picture" accept="image/*" data-type='image'>
									</div>
									<div class="col-md-1 no-padding">
										<button class="btn btn-primary pull-right" id="btnSaveImage">SAVE</button>
									</div>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{ Session::token() }}">
						</form>
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
	<script src="/js/custom/admin/utility/company.js"></script>
@endsection