@extends('layouts.default')
@section ('page_heading','Roles / Permissions')
@section('content')



<div class="container-fluid">
	<div class="panel panel-default">

		<div class="col-lg-4 col-md-4 col-sm-4 nopadding" >
			<div class="panel panel-default">
				<div class="panel-heading">Roles</div>
				<ul>
					@foreach ($roles as $role)
					<li><a href="#">{{ $role->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 nopadding" >
			<div class="panel panel-default">
				<div class="panel-heading">Permissions</div>
				<ul>
					@foreach ($permissions as $permission)
					<li><a href="#">{{ $permission->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>

	</div>
</div>



@stop
