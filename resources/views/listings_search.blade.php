@extends('layouts.template')
@section('content')
	
	{!! Form::open(array('route' => 'listings.search_results', 'method' => 'post')) !!}
		<div class="row">
			{!! Form::label('query', 'Search terms') !!}
			{!! Form::text('query') !!}
		</div>

		<div class="row">
			<div class="large-4 columns">
				{!! Form::label('mls', 'MLS #') !!}
				{!! Form::checkbox('mls', 'true') !!}
			</div>

			<div class="large-4 columns">
				{!! Form::label('city_state', 'City or state') !!}
				{!! Form::checkbox('city_state', 'true') !!}
			</div>

			<div class="large-4 columns">
				{!! Form::label('zip', 'Zip code') !!}
				{!! Form::checkbox('zip', 'true') !!}
			</div>
		</div>

		<hr />

		<div class="row">
			<div class="large-6 columns">
				{!! Form::label('date', 'Use date range') !!}
				{!! Form::checkbox('date', 'true') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('date_start', 'Date start') !!}
				{!! Form::date('date_start') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('date_end', 'Date end') !!}
				{!! Form::date('date_end', \Carbon\Carbon::now()) !!}
			</div>
		</div>

		<hr />

		<div class="row">
			<div class="large-6 columns">
				{!! Form::label('bedrooms', 'Use bedrooms range') !!}
				{!! Form::checkbox('bedrooms', 'true') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('bedrooms_min', 'Minimum bedrooms') !!}
				{!! Form::number('bedrooms_min') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('bedrooms_max', 'Maximum bedrooms') !!}
				{!! Form::number('bedrooms_max', \Carbon\Carbon::now()) !!}
			</div>
		</div>

		<hr />

		<div class="row">
			<div class="large-6 columns">
				{!! Form::label('square_feet', 'Use square foot range') !!}
				{!! Form::checkbox('square_feet', 'true') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('square_feet_min', 'Minimum square feet') !!}
				{!! Form::number('square_feet_min') !!}
			</div>

			<div class="large-6 columns">
				{!! Form::label('square_feet_max', 'Maximum square feet') !!}
				{!! Form::number('square_feet_max', \Carbon\Carbon::now()) !!}
			</div>
		</div>

		{!! Form::submit('search', array('class' => 'button')) !!}

	{!! Form::close() !!}

	<hr />
	@if (isset($results)) 
		<h2>Results:</h2>
		@foreach ($results as $listing)

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

	@endif

@stop