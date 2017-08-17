@extends('applicant.templates.default')

@section('content')
	<section class="content-header">
        <h1>PROFILE</h1>
    </section>

    <section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
		    			<form enctype="multipart/form-data" role="form" method="POST" action="{{ route('applicant-picture-save') }}">
							<div class="box-header">
								<h3>PROFILE IMAGE</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<input type="file" class="form-control" name="picture" id="picture" accept="image/*" data-type='image'>
								</div>
								<div class="form-group">
									<img id="pictureview" src="/applicant/{{Auth::user()->applicant->picture}}" alt="IMAGE" style="width: 50%; height: 50%;" class="center-block">
								</div>
							</div>
							<div class="box-footer">
								<div class="form-group">
									<button class="btn btn-primary pull-right" id="btnSave">SAVE</button>
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

@section('script')
	<script src="/js/custom/applicant/profile.js"></script>
@endsection