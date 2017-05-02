@extends('layouts.default')

@section ('page_heading','Users')
@section('content')

<div class="container-fluid">


 <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>id</th>
        <th>First</th>
        <th>Last</th>
        <th>Email</th>
        <th>Role</th>
        <th>Department</th>
      </tr>
    </thead>

    <tbody>
        @foreach ($users as $user)
        <tr>
            <td></td>
            <td>{{$user->id}}</td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td>{{
                Form::select(
                    'role',
                    $roles->pluck('name'),
                    $user->roles->first(),
                    ['placeholder' => ""])
                }}</td>
            <td>{{$user->department}}</td>
        </tr>
        @endforeach

    </tbody>
  </table>


</div>


@stop
