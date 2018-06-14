{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@include('pages.customercare.viewList.list.head')

@section('content')

	@yield('list')

	<div id="ajax-response-modal"></div>
	
@endsection
