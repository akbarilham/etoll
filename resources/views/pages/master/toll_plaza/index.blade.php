{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@include('pages.master.toll_plaza.list.head')

@section('content')

	@yield('list')

	<div id="ajax-response-modal"></div>
	
@endsection