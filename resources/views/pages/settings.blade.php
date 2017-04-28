@extends('layouts.default')

@section('content')
    <div class="row">
    	<div class="col-sm-4"></div>
    	<div class="col-sm-8">
    		<passport-clients></passport-clients>
    		<passport-authorized-clients></passport-authorized-clients>
    		<passport-personal-access-tokens></passport-personal-access-tokens>
    	</div>

    </div>
@stop
