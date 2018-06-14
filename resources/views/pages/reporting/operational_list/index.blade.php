{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@include('pages.reporting.operational_list.list.head')

@section('content')

	@yield('list')

	<div id="ajax-response-modal"></div>
	
@endsection