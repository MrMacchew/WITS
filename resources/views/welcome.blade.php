@extends('layouts.blank', ['sidebar' => false])

@section('content')

    <div class="title m-b-md">
        WITS
    </div>

    <div>
        @if (Auth::check())
            @role('user')
                I'm a user!
            @else
                I'm not a user...
            @endrole
        @endif
    </div>
</div>
@endsection



