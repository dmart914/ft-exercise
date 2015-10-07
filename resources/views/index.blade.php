@extends('layouts.template')
@section('content')
 	<h2>All listings</h2>
 	{!! link_to_route('listings.create', 'Create new listing', null, ['class' => 'success button']) !!}
 	<ul>
 		@foreach ($listings as $listing)

 			<li>
	 			<h4>{!! link_to_route('listings.show', $listing->mls_number, [$listing->id]) !!}</h4>
	 			<ul class="no-bullet">
	 				<li>Date listed: {{{ $listing->date_listed }}}</li>
	 				<li>{{{ $listing->street_1 }}} {{{ $listing->street_2 }}}</li>
	 				<li>{{{ $listing->city }}}, {{{ $listing->state }}} {{{ $listing->zip }}}</li>
	 				<li>Neighborhood: {{{ $listing->neighborhood }}}</li>
	 				<li>Sq. ft: {{{ $listing->square_feet }}}</li>
	 			</ul>
	 		</li>

 		@endforeach
 	</ul>
@stop
