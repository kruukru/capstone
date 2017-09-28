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
										<label>Company Name</label>
										<input type="text" class="form-control" id="name" value="{{$company->name}}" maxlength="100" required>
									</div>
									<div class="col-md-3">
										<label>Company Short Name</label>
										<input type="text" class="form-control" id="shortname" value="{{$company->shortname}}" maxlength="9" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Company Address</label>
								<textarea class="form-control" rows="2" id="address" required>{{$company->address}}</textarea>
							</div>
							<div class="form-group">
								<label>Company Contact No.</label>
								<input type="text" class="form-control" id="contactno" value="{{$company->contactno}}" required>
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