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
<body class="skin-blue">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <img src="/images/{{$company->logo}}" style="height: 40px; width: 40px;">
      <span class="logo-sm"><b>{{$company->shortname}}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      
    </nav>
  </header>

  @include('templates.alert')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <section class="content">
                    <div class="error-page">
                        <h2 class="headline text-yellow">404</h2>
                        <div class="error-content">
                        	<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
	                        <h3>
	                            We could not find the page you were looking for.
	                            Meanwhile, you may return to <a href="{{ route('home') }}">home</a> page.
	                        </h3>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
  @include('templates.myjs')
  @yield('script')
</body>
</html>