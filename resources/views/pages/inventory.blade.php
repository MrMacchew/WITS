@extends('layouts.default', ['sidebar' => true])

@section ('page_heading','Inventory')
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

		<div id="collapse3" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
			<div class="panel-body">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. In accusantium fuga obcaecati debitis asperiores voluptates vero, est, dignissimos similique alias quis? Vitae commodi hic sit pariatur sapiente id est alias..
			</div>
		</div>
	</div>
</div>

@stop
