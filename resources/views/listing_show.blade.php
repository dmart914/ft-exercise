@extends('layouts.template')
@section('content')
	<h1>MLS #{{{ $listing->mls_number }}}</h1>
	<ul class="no-bullet button-group">
        <li>
            {!! link_to_route('listings.edit', 'edit', $listing->id, ['class' => 'tiny button']) !!}
        </li>
        <li>
            {!! Form::model($listing, array('route' => ['listings.destroy', $listing->id], 'method' => 'delete'))  !!}
                {!! Form::button('destroy', ['type' => 'submit', 'class' => 'tiny alert button']) !!}
            {!! Form::close() !!}
        </li>
    </ul>
	<h4>{{{ $listing->bedrooms }}} bedrooms, {{{ $listing->square_feet }}} sq. ft.</h4>
	<h4>{{{ $listing->street_1 }}} {{{ $listing->street_2 }}}</h4>
	<h4>{{{ $listing->city }}}, {{{ $listing->state }}} {{{ $listing->zip }}}</h4>
	<h4>Neighborhood: {{{ $listing->neighborhood }}}</h4>
	<h4>Sale price: {{{ $listing->sale_price }}}</h4>
	<h4>Listed {{{ $listing->date_listed }}}</h4>
	<p>{{{ $listing->description }}}</p>
	<hr />
	<div id="row">
		@foreach ($photos as $p)
			@if (strlen($p) > 1)
				<div class="large-4 columns">
					<img src="/ft/photos/{{{ ($p) }}}" />
				</div>
			@endif
		@endforeach
	</div>
@stop