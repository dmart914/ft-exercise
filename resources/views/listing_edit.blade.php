@extends('layouts.template')
@section('content')
	{!! Form::model($listing, array('route' => ['listings.update', $listing->id], 'method' => 'PUT')) !!}

	@if (count($errors) > 0) 

		@foreach($errors->all() as $error)
			<small class="error">{{ $error }}</small>
		@endforeach

	@endif

	{!! Form::label('mls_number', 'MLS #') !!}
  	{!! Form::number('mls_number') !!}

	{!! Form::label('street_1', 'Street 1') !!}
  	{!! Form::text('street_1') !!}

  	{!! Form::label('street_2', 'Street 2') !!}
  	{!! Form::text('street_2') !!}

  	{!! Form::label('city', 'City') !!}
  	{!! Form::text('city') !!}

  	{!! Form::label('state', 'State') !!}
  	{!! Form::text('state') !!}

  	{!! Form::label('zip', 'Zip code') !!}
  	{!! Form::number('zip') !!}

  	{!! Form::label('neighborhood', 'Neighborhood') !!}
  	{!! Form::text('neighborhood') !!}

  	{!! Form::label('sale_price', 'Sale price') !!}
  	{!! Form::number('sale_price') !!}

  	{!! Form::label('date_listed', 'Date listed') !!}
  	{!! Form::date('date_listed', \Carbon\Carbon::now()) !!}

  	{!! Form::label('bedrooms', 'Bedrooms') !!}
  	{!! Form::number('bedrooms') !!}

  	<p>{{{ $photocount }}} photos.</p>
  	<div class="row">
	  	@foreach ($photos as $p)
			@if (strlen($p) > 1)
				<div class="large-4 columns">
					<img src="/ft/photos/{{{ ($p) }}}" />
				</div>
			@endif
		@endforeach
	</div>

	<br />

  	{!! Form::label('photos', 'Add photos') !!}
  	{!! Form::file('photos') !!}

  	{!! Form::label('square_feet', 'Square feet') !!}
  	{!! Form::number('square_feet') !!}

  	{!! Form::label('description', 'Description') !!}
  	{!! Form::textarea('description') !!}

  	{!! Form::submit('update', array('class' => 'button')) !!}

	{!! Form::close() !!}


@stop