@extends('admin.templates.default')

@section('content')
    <section class="content-header">
		<h1>Test Login</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<div class="col-sm-6 col-sm-offset-3">
							<form id="formTestLogin" data-parsley-validate>
								<div class="form-group">
				                	<label class="control-label">Username</label>
				                	<input type="text" id="username" placeholder="Username" class="form-control" required>
					            </div>
					            <div class="form-group">
				                	<label class="control-label">Password</label>
				                	<input type="password" id="password" placeholder="Password" class="form-control" required>
					            </div>
				                <button id="btnLogin" class="btn btn-primary pull-right">Sign In</button>
				            </form>
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
	<script src="/js/custom/admin/transaction/testlogin.js"></script>
@endsection