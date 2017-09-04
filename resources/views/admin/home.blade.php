@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<section class="content">
	<div class="row">
		<div class="container col-sm-6">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					
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
<script src="/js/custom/admin/home.js"></script>
@endsection