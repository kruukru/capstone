<!DOCTYPE html>
<html>
<head>
	<title>{{$company->shortname}}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	@yield('meta')

	@include('templates.mycss')
	@yield('css')
</head>
<body class="skin-blue fixed hold-transition sidebar-mini">
	<!-- HEADER -->
	<header class="main-header">
		<!-- Logo -->
		<a href="{{ route('home') }}" class="logo">
			<span class="logo-mini"><img src="/images/{{$company->logo}}" style="height: 30px; width: 30px;"></span>
			<span class="logo-lg"><img src="/images/{{$company->logo}}" style="height: 40px; width: 40px;"><b> {{$company->shortname}}</b></span>
		</a>
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- Notification -->
					<li class="dropdown notifications-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-bell-o"></i>
							<span class="label label-warning">{{$notifications->count() == 0 ? "" : $notifications->count()}}</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">You have {{$notifications->count() == 0 ? "no" : $notifications->count()}} notification(s)</li>
							<li>
								<ul class="menu">
									@foreach ($notifications as $notification)
										<li><a href="#"><i class="fa fa-warning {{$notification['priority'] == 1 ? 'text-red' : 'text-yellow'}}"></i>{{$notification['description']}}</a></li>
									@endforeach
								</ul>
							</li>
							<li class="footer"><a href="{{ route('admin-notification') }}">View all</a></li>
						</ul>
					</li>
					<!-- User Account Menu -->
					<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<!-- The user image in the navbar-->
							<img src="/admin/{{Auth::user()->admin->picture}}" class="user-image" alt="User Image"/>
							<!-- hidden-xs hides the username on small devices so only the image appears. -->
							<span class="hidden-xs" id="clockTime"></span>
						</a>
						<ul class="dropdown-menu">
							<!-- The user image in the menu -->
							<li class="user-header">
								<img src="/admin/{{Auth::user()->admin->picture}}" class="img-circle" alt="User Image" />
								<p>{{Auth::user()->admin->firstname}} {{Auth::user()->admin->lastname}} - {{Auth::user()->admin->position}}</p>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-right">
									<a href="{{ route('signout') }}" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<!-- SIDEBAR -->
	<aside class="main-sidebar">
		<section class="sidebar">
			<!-- user image -->
			<div class="user-panel" style="min-height: 65px;">
				<div class="pull-left image">
					<img src="/admin/{{Auth::user()->admin->picture}}" class="img-circle" alt="User Image" />
				</div>
				<div class="pull-left info">
					<p>{{Auth::user()->admin->lastname}}</p>
					<p>{{Auth::user()->admin->firstname}}</p>
				</div>
			</div>

			<!-- list of button -->
			<ul class="sidebar-menu">
				<!-- separator -->
				<li class="header"></li>
				<!-- transaction -->
				<li class="treeview {{Request::path() == 'admin/transaction/submitcredential' ? 'active' : ''}} {{Request::path() == 'admin/transaction/testlogin' ? 'active' : ''}} {{Request::path() == 'admin/transaction/assesstest' ? 'active' : ''}} {{Request::path() == 'admin/transaction/assessinterview' ? 'active' : ''}} {{Request::path() == 'admin/transaction/securityguard' ? 'active' : ''}} {{Request::path() == 'admin/transaction/contract' ? 'active' : ''}} {{Request::path() == 'admin/transaction/client' ? 'active' : ''}} {{Request::path() == 'admin/transaction/inventory' ? 'active' : ''}} {{Request::path() == 'admin/transaction/deploysecurityguard' ? 'active' : ''}} {{Request::path() == 'admin/transaction/deployitem' ? 'active' : ''}} {{Request::path() == 'admin/transaction/request' ? 'active' : ''}} {{Request::path() == 'admin/transaction/report' ? 'active' : ''}} {{Request::path() == 'admin/transaction/leaveabsent' ? 'active' : ''}}">
					<a href="#"><i class="fa fa-suitcase"></i><span>TRANSACTION</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						@if (Auth::user()->accounttype == 0)
							<li class="{{Request::path() == 'admin/transaction/client' ? 'active' : ''}}"><a href="{{ route('admin-transaction-client') }}"><i class="fa fa-circle-o"></i>Client</a></li>
							<li class="{{Request::path() == 'admin/transaction/contract' ? 'active' : ''}}"><a href="{{ route('admin-transaction-contract') }}"><i class="fa fa-circle-o"></i>Contract</a></li>
							<li class="{{Request::path() == 'admin/transaction/submitcredential' ? 'active' : ''}}"><a href="{{ route('admin-transaction-submitcredential') }}"><i class="fa fa-circle-o"></i>Submit Credentials</a></li>
							<li class="{{Request::path() == 'admin/transaction/testlogin' ? 'active' : ''}}"><a href="{{ route('admin-transaction-testlogin') }}"><i class="fa fa-circle-o"></i>Testing</a></li>
							<li class="{{Request::path() == 'admin/transaction/assesstest' ? 'active' : ''}}"><a href="{{ route('admin-transaction-assesstest') }}"><i class="fa fa-circle-o"></i>Assess Test</a></li>
							<li class="{{Request::path() == 'admin/transaction/assessinterview' ? 'active' : ''}}"><a href="{{ route('admin-transaction-assessinterview') }}"><i class="fa fa-circle-o"></i>Assess Interview</a></li>
							<li class="{{Request::path() == 'admin/transaction/securityguard' ? 'active' : ''}}"><a href="{{ route('admin-transaction-securityguard') }}"><i class="fa fa-circle-o"></i>Security Guard</a></li>
							<li class="{{Request::path() == 'admin/transaction/inventory' ? 'active' : ''}}"><a href="{{ route('admin-transaction-inventory') }}"><i class="fa fa-circle-o"></i>Inventory</a></li>
							<li class="{{Request::path() == 'admin/transaction/deploysecurityguard' ? 'active' : ''}}"><a href="{{ route('admin-transaction-deploysecurityguard') }}"><i class="fa fa-circle-o"></i>Deploy Security Guard</a></li>
							<li class="{{Request::path() == 'admin/transaction/deployitem' ? 'active' : ''}}"><a href="{{ route('admin-transaction-deployitem') }}"><i class="fa fa-circle-o"></i>Deploy Item</a></li>
							<li class="{{Request::path() == 'admin/transaction/request' ? 'active' : ''}}"><a href="{{ route('admin-transaction-request') }}"><i class="fa fa-circle-o"></i>Request</a></li>
							<li class="{{Request::path() == 'admin/transaction/report' ? 'active' : ''}}"><a href="{{ route('admin-transaction-report') }}"><i class="fa fa-circle-o"></i>Report</a></li>
							<li class="{{Request::path() == 'admin/transaction/leaveabsent' ? 'active' : ''}}"><a href="{{ route('admin-transaction-leaveabsent') }}"><i class="fa fa-circle-o"></i>Leave / Absent</a></li>
						@elseif (Auth::user()->accounttype == 1)
							<li class="{{Request::path() == 'admin/transaction/inventory' ? 'active' : ''}}"><a href="{{ route('admin-transaction-inventory') }}"><i class="fa fa-circle-o"></i>Inventory</a></li>
							<li class="{{Request::path() == 'admin/transaction/deployitem' ? 'active' : ''}}"><a href="{{ route('admin-transaction-deployitem') }}"><i class="fa fa-circle-o"></i>Deploy Item</a></li>
						@elseif (Auth::user()->accounttype == 2)
							<li class="{{Request::path() == 'admin/transaction/request' ? 'active' : ''}}"><a href="{{ route('admin-transaction-request') }}"><i class="fa fa-circle-o"></i>Request</a></li>
							<li class="{{Request::path() == 'admin/transaction/report' ? 'active' : ''}}"><a href="{{ route('admin-transaction-report') }}"><i class="fa fa-circle-o"></i>Report</a></li>
							<li class="{{Request::path() == 'admin/transaction/leaveabsent' ? 'active' : ''}}"><a href="{{ route('admin-transaction-leaveabsent') }}"><i class="fa fa-circle-o"></i>Leave / Absent</a></li>
						@elseif (Auth::user()->accounttype == 3)
							<li class="{{Request::path() == 'admin/transaction/submitcredential' ? 'active' : ''}}"><a href="{{ route('admin-transaction-submitcredential') }}"><i class="fa fa-circle-o"></i>Submit Credentials</a></li>
							<li class="{{Request::path() == 'admin/transaction/testlogin' ? 'active' : ''}}"><a href="{{ route('admin-transaction-testlogin') }}"><i class="fa fa-circle-o"></i>Testing</a></li>
							<li class="{{Request::path() == 'admin/transaction/assesstest' ? 'active' : ''}}"><a href="{{ route('admin-transaction-assesstest') }}"><i class="fa fa-circle-o"></i>Assess Test</a></li>
							<li class="{{Request::path() == 'admin/transaction/assessinterview' ? 'active' : ''}}"><a href="{{ route('admin-transaction-assessinterview') }}"><i class="fa fa-circle-o"></i>Assess Interview</a></li>
							<li class="{{Request::path() == 'admin/transaction/securityguard' ? 'active' : ''}}"><a href="{{ route('admin-transaction-securityguard') }}"><i class="fa fa-circle-o"></i>Security Guard</a></li>
							<li class="{{Request::path() == 'admin/transaction/deploysecurityguard' ? 'active' : ''}}"><a href="{{ route('admin-transaction-deploysecurityguard') }}"><i class="fa fa-circle-o"></i>Deploy Security Guard</a></li>
						@endif
					</ul>
				</li>
				<!-- maintenance -->
				<li class="treeview {{Request::path() == 'admin/maintenance/requirement' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/test' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/assessmenttopic' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/itemtype' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/item' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/commend' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/violation' ? 'active' : ''}}">
					<a href="#"><i class="fa fa-cogs"></i><span>MAINTENANCE</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						@if (Auth::user()->accounttype == 0)
							<li class="{{Request::path() == 'admin/maintenance/requirement' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-requirement') }}"><i class="fa fa-circle-o"></i>Applicant Requirement</a></li>
							<!-- treeview for test -->
							<li class="treeview {{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/test' ? 'active' : ''}}">
								<a href="#"><span>Test</span><i class="fa fa-angle-left"></i></a>
								<ul class="treeview-menu">
									<!-- treeview for question -->
									<li class="treeview {{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}}">
										<a href="#"><span></i>Question</span><i class="fa fa-angle-left pull-right"></i></a>
										<ul class="treeview-menu">
											<li class="{{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-multiplechoice') }}"><i class="fa fa-circle-o"></i>Multiple Choice</a></li>
											<li class="{{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-trueorfalse') }}"><i class="fa fa-circle-o"></i>True or False</a></li>
											<li class="{{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-identification') }}"><i class="fa fa-circle-o"></i>Identification</a></li>
											<li class="{{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-essay') }}"><i class="fa fa-circle-o"></i>Essay</a></li>
										</ul>
									</li>
									<li class="{{Request::path() == 'admin/maintenance/test' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-test') }}"><i class="fa fa-circle-o"></i>Test Form</a></li>
								</ul>
							</li>
							<li class="{{Request::path() == 'admin/maintenance/assessmenttopic' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-assessmenttopic') }}"><i class="fa fa-circle-o"></i>Assessment Topic</a></li>
							<li class="{{Request::path() == 'admin/maintenance/itemtype' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-itemtype') }}"><i class="fa fa-circle-o"></i>Item Type</a></li>
							<li class="{{Request::path() == 'admin/maintenance/item' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-item') }}"><i class="fa fa-circle-o"></i>Item</a></li>
							<li class="{{Request::path() == 'admin/maintenance/commend' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-commend') }}"><i class="fa fa-circle-o"></i>Commend</a></li>
							<li class="{{Request::path() == 'admin/maintenance/violation' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-violation') }}"><i class="fa fa-circle-o"></i>Violation</a></li>
						@elseif (Auth::user()->accounttype == 1)
							<li class="{{Request::path() == 'admin/maintenance/itemtype' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-itemtype') }}"><i class="fa fa-circle-o"></i>Item Type</a></li>
							<li class="{{Request::path() == 'admin/maintenance/item' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-item') }}"><i class="fa fa-circle-o"></i>Item</a></li>
						@elseif (Auth::user()->accounttype == 2)
							<li class="{{Request::path() == 'admin/maintenance/commend' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-commend') }}"><i class="fa fa-circle-o"></i>Commend</a></li>
							<li class="{{Request::path() == 'admin/maintenance/violation' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-violation') }}"><i class="fa fa-circle-o"></i>Violation</a></li>
						@elseif (Auth::user()->accounttype == 3)
							<li class="{{Request::path() == 'admin/maintenance/requirement' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-requirement') }}"><i class="fa fa-circle-o"></i>Applicant Requirement</a></li>
							<!-- treeview for test -->
							<li class="treeview {{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/test' ? 'active' : ''}}">
								<a href="#"><span>Test</span><i class="fa fa-angle-left"></i></a>
								<ul class="treeview-menu">
									<!-- treeview for question -->
									<li class="treeview {{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}} {{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}}">
										<a href="#"><span></i>Question</span><i class="fa fa-angle-left pull-right"></i></a>
										<ul class="treeview-menu">
											<li class="{{Request::path() == 'admin/maintenance/multiplechoice' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-multiplechoice') }}"><i class="fa fa-circle-o"></i>Multiple Choice</a></li>
											<li class="{{Request::path() == 'admin/maintenance/trueorfalse' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-trueorfalse') }}"><i class="fa fa-circle-o"></i>True or False</a></li>
											<li class="{{Request::path() == 'admin/maintenance/identification' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-identification') }}"><i class="fa fa-circle-o"></i>Identification</a></li>
											<li class="{{Request::path() == 'admin/maintenance/essay' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-essay') }}"><i class="fa fa-circle-o"></i>Essay</a></li>
										</ul>
									</li>
									<li class="{{Request::path() == 'admin/maintenance/test' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-test') }}"><i class="fa fa-circle-o"></i>Test Form</a></li>
								</ul>
							</li>
							<li class="{{Request::path() == 'admin/maintenance/assessmenttopic' ? 'active' : ''}}"><a href="{{ route('admin-maintenance-assessmenttopic') }}"><i class="fa fa-circle-o"></i>Assessment Topic</a></li>
						@endif
					</ul>
				</li>
				@if (Auth::user()->accounttype == 0 || Auth::user()->accounttype == 3)
					<!-- utilities -->
					<li class="treeview {{Request::path() == 'admin/utility/account' ? 'active' : ''}} {{Request::path() == 'admin/utility/company' ? 'active' : ''}} {{Request::path() == 'admin/utility/appointment' ? 'active' : ''}}">
						<a href="#"><i class="fa fa-th-list"></i><span>UTILITY</span><i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							@if (Auth::user()->accounttype == 0)
								<li class="{{Request::path() == 'admin/utility/account' ? 'active' : ''}}"><a href="{{ route('admin-utility-account') }}"><i class="fa fa-circle-o"></i>Account</a></li>
								<li class="{{Request::path() == 'admin/utility/company' ? 'active' : ''}}"><a href="{{ route('admin-utility-company') }}"><i class="fa fa-circle-o"></i>Company</a></li>
								<li class="{{Request::path() == 'admin/utility/appointment' ? 'active' : ''}}"><a href="{{ route('admin-utility-appointment') }}"><i class="fa fa-circle-o"></i>Appointment</a></li>
							@elseif (Auth::user()->accounttype == 1)
								
							@elseif (Auth::user()->accounttype == 2)

							@elseif (Auth::user()->accounttype == 3)
								<li class="{{Request::path() == 'admin/utility/appointment' ? 'active' : ''}}"><a href="{{ route('admin-utility-appointment') }}"><i class="fa fa-circle-o"></i>Appointment</a></li>
							@endif
						</ul>
					</li>
				@endif
				<!-- archive -->
				<li class="treeview {{Request::path() == 'admin/archive/commend' ? 'active' : ''}} {{Request::path() == 'admin/archive/requirement' ? 'active' : ''}} {{Request::path() == 'admin/archive/violation' ? 'active' : ''}} {{Request::path() == 'admin/archive/itemtype' ? 'active' : ''}} {{Request::path() == 'admin/archive/item' ? 'active' : ''}} {{Request::path() == 'admin/archive/assessmenttopic' ? 'active' : ''}} {{Request::path() == 'admin/archive/question' ? 'active' : ''}} {{Request::path() == 'admin/archive/test' ? 'active' : ''}}">
					<a href="#"><i class="fa fa-archive"></i><span>ARCHIVE</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						@if (Auth::user()->accounttype == 0)
							<li class="{{Request::path() == 'admin/archive/requirement' ? 'active' : ''}}"><a href="{{ route('admin-archive-requirement') }}"><i class="fa fa-circle-o"></i>Applicant Requirement</a></li>
							<li class="{{Request::path() == 'admin/archive/test' ? 'active' : ''}}"><a href="{{ route('admin-archive-test') }}"><i class="fa fa-circle-o"></i>Test Form</a></li>
							<li class="{{Request::path() == 'admin/archive/question' ? 'active' : ''}}"><a href="{{ route('admin-archive-question') }}"><i class="fa fa-circle-o"></i>Question</a></li>
							<li class="{{Request::path() == 'admin/archive/assessmenttopic' ? 'active' : ''}}"><a href="{{ route('admin-archive-assessmenttopic') }}"><i class="fa fa-circle-o"></i>Assessment Topic</a></li>
							<li class="{{Request::path() == 'admin/archive/itemtype' ? 'active' : ''}}"><a href="{{ route('admin-archive-itemtype') }}"><i class="fa fa-circle-o"></i>Item Type</a></li>
							<li class="{{Request::path() == 'admin/archive/item' ? 'active' : ''}}"><a href="{{ route('admin-archive-item') }}"><i class="fa fa-circle-o"></i>Item</a></li>
							<li class="{{Request::path() == 'admin/archive/commend' ? 'active' : ''}}"><a href="{{ route('admin-archive-commend') }}"><i class="fa fa-circle-o"></i>Commend</a></li>
							<li class="{{Request::path() == 'admin/archive/violation' ? 'active' : ''}}"><a href="{{ route('admin-archive-violation') }}"><i class="fa fa-circle-o"></i>Violation</a></li>
						@elseif (Auth::user()->accounttype == 1)
							<li class="{{Request::path() == 'admin/archive/itemtype' ? 'active' : ''}}"><a href="{{ route('admin-archive-itemtype') }}"><i class="fa fa-circle-o"></i>Item Type</a></li>
							<li class="{{Request::path() == 'admin/archive/item' ? 'active' : ''}}"><a href="{{ route('admin-archive-item') }}"><i class="fa fa-circle-o"></i>Item</a></li>
						@elseif (Auth::user()->accounttype == 2)
							<li class="{{Request::path() == 'admin/archive/commend' ? 'active' : ''}}"><a href="{{ route('admin-archive-commend') }}"><i class="fa fa-circle-o"></i>Commend</a></li>
						<li class="{{Request::path() == 'admin/archive/violation' ? 'active' : ''}}"><a href="{{ route('admin-archive-violation') }}"><i class="fa fa-circle-o"></i>Violation</a></li>
						@elseif (Auth::user()->accounttype == 3)
							<li class="{{Request::path() == 'admin/archive/requirement' ? 'active' : ''}}"><a href="{{ route('admin-archive-requirement') }}"><i class="fa fa-circle-o"></i>Applicant Requirement</a></li>
							<li class="{{Request::path() == 'admin/archive/test' ? 'active' : ''}}"><a href="{{ route('admin-archive-test') }}"><i class="fa fa-circle-o"></i>Test Form</a></li>
							<li class="{{Request::path() == 'admin/archive/question' ? 'active' : ''}}"><a href="{{ route('admin-archive-question') }}"><i class="fa fa-circle-o"></i>Question</a></li>
							<li class="{{Request::path() == 'admin/archive/assessmenttopic' ? 'active' : ''}}"><a href="{{ route('admin-archive-assessmenttopic') }}"><i class="fa fa-circle-o"></i>Assessment Topic</a></li>
						@endif
					</ul>
				</li>
				@if (Auth::user()->accounttype != 1)
					<!-- queries -->
					<li class="{{Request::path() == 'admin/query' ? 'active' : ''}}"><a href="{{ route('admin-query') }}"><i class="fa fa-book"></i>QUERY</a></li>
				@endif
				@if (Auth::user()->accounttype != 2)
					<!-- reports -->
					<li class="{{Request::path() == 'admin/report' ? 'active' : ''}}"><a href="{{ route('admin-report') }}"><i class="fa fa-file-text"></i>REPORT</a></li>
				@endif
			</ul>
		</section>
	</aside>

	<div class="wrapper">
		<div class="content-wrapper">
			@include('templates.alert')
			@yield('content')
		</div>
	</div>

	@include('templates.myjs')
	@yield('script')
	<script type="text/javascript">
		function updateClock() {
			$('#clockTime').text(moment().format('MMMM D, YYYY - H:mm:ss'))
		}
		setInterval(updateClock, 1000);
	</script>
</body>
</html>