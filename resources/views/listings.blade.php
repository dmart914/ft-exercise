@extends('layouts.template')
@section('content')
  {!! Form::model($listings, array('route' => 'listings.update')) !!}


@stop
