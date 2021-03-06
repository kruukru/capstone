<!DOCTYPE html>
<html>
<head>
	<title>AMCOR</title>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  	<meta name="_token" content="{{ Session::token() }}" />

	@include('templates.mycss')
	<style type="text/css">
		.fix-top {
			top: 0;
		    z-index: 100;
		  	position: fixed;
		    width: 30%;
		}
	</style>
</head>
<body class="skin-blue">
  	<header class="main-header">
	    <!-- Logo -->
	    <a href="#" class="logo">
	    	<img src="/images/{{$company->logo}}" style="height: 40px; width: 40px;">
	      	<span class="logo-sm"><b>{{$company->shortname}}</b></span>
	    </a>

	    <!-- Header Navbar -->
	    <nav class="navbar navbar-static-top" role="navigation">
	      	<div class="container-fluid"></div>
	    </nav>
  	</header>

  	<section class="content-header" id="timeLimit">
		<div class="row">
			<div class="container col-sm-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<div class="box box-primary box-body" id="testpreview"></div>
						<div class="box-body">
							<div class="form-group">
		            			<h3 id="time"></h3>
		            			<button class="btn btn-success pull-right" id="btnStart">START TEST</button>
		            			<button class="btn btn-success pull-right" id="btnSubmit" style="display: none;">DONE</button>
			            	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<form id='formQuestion' data-parsley-validate>
			<div class="row" id="test-list"></div>
		</form>
	</section>

	<!-- modal for confirmation -->
	<div class="modal fade" id="modalConfirm">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>CONFIRMATION</h3>
				</div>
				<!-- modal body -->
				<div class="modal-body">
					Are you sure you are done?
				</div>
				<!-- modal footer -->
				<div class="modal-footer">
					<button class="btn btn-primary" id="btnConfirm">CONFIRM</button>
        			<button class="btn btn-default" data-dismiss="modal">CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	@include('templates.myjs')
	<script src="/js/custom/admin/transaction/test.js"></script>
</body>
</html>