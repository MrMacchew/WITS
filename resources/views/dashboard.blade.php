@extends('layouts.default', ['sidebar' => true])

@section ('page_heading','Dashboard')
@section('content')

<div id="accordion" class="panel-group">
	<div class="panel panel-success">

		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" class="collapsed">
					This is a header
				</a>
			</h4>
		</div>

		<div id="collapse3" class="panel-collapse collapse in" aria-expanded="true" style="height: 0px;">
			<div class="panel-body">
				Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
			</div>
		</div>
	</div>
</div>

@endsection
