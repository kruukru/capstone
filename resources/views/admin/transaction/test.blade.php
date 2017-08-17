<!DOCTYPE html>
<html>
<head>
	<title>AMCOR</title>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  	<meta name="_token" content="{{ Session::token() }}" />

	@include('templates.mycss')
</head>
<body class="skin-purple">
  	<header class="main-header">
	    <!-- Logo -->
	    <a href="#" class="logo">
	    	<img src="/images/amcor.png" style="height: 40px; width: 40px;">
	      	<span class="logo-sm"><b>AMCOR</b></span>
	    </a>

	    <!-- Header Navbar -->
	    <nav class="navbar navbar-static-top" role="navigation">
	      	<div class="container-fluid">
	        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
	          		<span class="fa fa-bars"></span>
	        	</button>
		        <div class="navbar-collapse collapse">
		          
		        </div>
	      	</div>
	    </nav>
  	</header>

  	<section class="content-header">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<div class="box-body">
							<div class="form-group">
			            		<div class="col-sm-1 col-sm-offset-9">
			            			<input type="button" name="btnStart" id="btnStart" value="Start" class="btn btn-success">
			            		</div>
			            		<div class="col-sm-1">
			            			<h3 id="time">TIME</h3>
			            		</div>
			            		<div class="col-sm-1">
			            			<h3>secs</h3>
			            		</div>
			            	</div>
			            	<hr>
			            	<hr>
			            	<hr>
			            	<div class="form-group">
			            		<div class="col-sm-12">
			            			<h1 id="testName">Test</h1>
			            		</div>
			            	</div>
			            	<div class="form-group">
			            		<div class="col-sm-12">
			            			<h3 id="testInstruction">Instruction</h3>
			            		</div>
			            	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<form id="formQuestion" data-parsley-validate>
							<div class="box-body" id="question-list">
							
							</div>
							<input type="submit" id="btnSubmit" class="btn btn-success pull-right" style="display: none;">
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('templates.myjs')
	<script src="/js/custom/admin/transaction/test.js"></script>
</body>
</html>