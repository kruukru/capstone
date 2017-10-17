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
  <style type="text/css">
    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: rgba(60, 141, 188, 1);
    }
  </style>
</head>
<body class="skin-blue">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <img src="images/{{$company->logo}}" style="height: 40px; width: 40px;">
      <span class="logo-sm"><b>{{$company->shortname}}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <div class="container-fluid">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="fa fa-bars"></span>
        </button>
        <div class="navbar-collapse collapse">
          <!-- <ul class="nav navbar-nav">
            <li><a href="{{ route('home') }}">HOME</a></li>
          </ul> -->
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ route('signup') }}">REGISTER</a></li>
            <li><a href="{{ route('signin') }}">SIGN IN</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  @include('templates.alert')
  @yield('content')
  <footer>
    <strong>&emsp;<b>COPYRIGHT © AMCOR SECURITY AND INVESTIGATION AGENCY 2017</b></strong>
  </footer>

  @include('templates.myjs')
  @yield('script')
  <script type="text/javascript">
  $.backstretch([
    "/images/bg1.jpg",
    "/images/bg2.jpg",
    "/images/bg3.jpg",
    "/images/bg4.jpg",
  ], {duration: 4000, fade: 2000});
</script>
</body>
</html>