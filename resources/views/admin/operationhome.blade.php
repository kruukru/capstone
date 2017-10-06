@extends('admin.templates.default')

@section('content')
<section class="content-header">
	<h1>Dashboard Operation</h1>
</section>
@endsection

@section('meta')
<meta name="_token" content="{{ Session::token() }}" />
@endsection

@section('script')
<!-- <script src="/js/custom/admin/home.js"></script> -->
@endsection