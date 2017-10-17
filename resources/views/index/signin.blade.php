@extends('index.templates.default')

@section('content')
<section class="content">
	<div class="row">
		<div class="container col-sm-4 col-sm-offset-4">
			<div class="box box-primary">
				<div class="box-header with-border">
    				<h3 class="box-title">SIGN IN</h3>
    			</div>
				<div class="box-body table-responsive">
					<form class="login-form" role="form" method="POST" action="#">
						<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
							<label class="sr-only" for="form-username">Username</label>
							<input type="text"  placeholder="Username" class="form-username form-control" name="username" id="username">
							@if($errors->has('username'))
							<span class="help-block">{{ $errors->first('username') }}</span>
							@endif
						</div>
						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label class="sr-only" for="form-password">Password</label>
							<input type="password" placeholder="Password" class="form-password form-control" name="password" id="password">
							@if($errors->has('password'))
							<span class="help-block">{{ $errors->first('password') }}</span>
							@endif
						</div>
						<button type="submit" class="btn btn-primary pull-right">SIGN IN</button>
						<input type="hidden" name="_token" value="{{ Session::token() }}">
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

	<!-- <div class="top-content">
	  <div class="inner-bg">
	    <div class="container col-md-6 col-md-offset-3">
	      <div class="row">
	        <div class="col-sm-6 col-sm-offset-3 form-box">
	          <div class="form-top">
	            <div class="form-top-left">
	              <h3>SIGN IN</h3>
	            </div>
	          </div>
	          <div class="form-bottom">
	            <form class="login-form" role="form" method="POST" action="#">
	              <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
	                <label class="sr-only" for="form-username">Username</label>
	                <input type="text"  placeholder="Username" class="form-username form-control" name="username" id="username">
	                @if($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
	              </div>
	              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	                <label class="sr-only" for="form-password">Password</label>
	                <input type="password" placeholder="Password" class="form-password form-control" name="password" id="password">
	                @if($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
	              </div>
	              <button type="submit" class="btn">Sign In</button>
				  <input type="hidden" name="_token" value="{{ Session::token() }}">
	            </form>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div> -->
@endsection