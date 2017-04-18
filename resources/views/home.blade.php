@extends('layouts.app')

@section('content')
<div class="container">

    <div>
        <example></example>
    </div>


    <div class="row">
        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>
</div>
@endsection
