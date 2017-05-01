@extends('layouts.default')
@section ('page_heading', 'Settings' . " " . Auth::user()->user)
@section('content')

	<passport-clients></passport-clients>
	<passport-authorized-clients></passport-authorized-clients>
	<passport-personal-access-tokens></passport-personal-access-tokens>

@stop
