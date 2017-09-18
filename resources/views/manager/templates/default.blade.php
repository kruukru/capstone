<!DOCTYPE html>
<html>
<head>
  <title>AMCOR</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  @yield('meta')

  @include('templates.mycss')
  @yield('css')
  
</head>
<body class="skin-blue fixed hold-transition sidebar-mini sidebar-collapse">
  <!-- HEADER -->
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <span class="logo-mini"><img src="/images/amcor.png" style="height: 30px; width: 30px;"></span>
      <span class="logo-lg"><img src="/images/amcor.png" style="height: 40px; width: 40px;"><b> AMCOR</b></span>
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
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="/images/default.png" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{Auth::user()->manager->firstname}} {{Auth::user()->manager->lastname}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="/images/default.png" class="img-circle" alt="User Image" />
                            <p>{{Auth::user()->manager->firstname}} {{Auth::user()->manager->lastname}}</p>
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
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/default.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->manager->lastname}}</p>
                <p>{{Auth::user()->manager->firstname}}</p>
            </div>
        </div>

        <!-- list of button -->
        <ul class="sidebar-menu">
            <li class="header"></li>
            <li class="{{Request::path() == 'manager/attendance' ? 'active' : ''}}"><a href="{{ route('manager-attendance') }}"><i class="fa fa-calendar-check-o"></i><span>Attendance</span></a></li>
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
</body>
</html>