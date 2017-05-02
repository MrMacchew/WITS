@extends('layouts.default')

@section ('page_heading','Users')
@section('content')



<div class="container-fluid">

 <table class="table table-striped" style="border-collapse:collapse;">
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
        @foreach ($users as $key => $user)
        <tr>
            <td data-toggle="collapse" data-target="#row{{$key}}" class="accordion-toggle" aria-expanded="false">
                    <i class="fa fa-chevron-right fa-fw"></i>
                    <i class="fa fa-chevron-down fa-fw"></i>
            </td>
            <td>{{$user->id}}</td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->email}}</td>
            <td >
            <select name="" class='form-control '>
                @foreach($rolesList as $list)
                    <option value="{{$list}}" {{ $user->roles->pluck('name')->first() == $list ?'selected':'' }}>{{$list}}</option>
                @endforeach
            </select>
            </td>
            <td>{{$user->department}}</td>
        </tr>
        <tr>
            <td colspan="6" style="padding: 0">
                <div class="container-fluid">



                    <div class="accordian-body collapse" id="row{{$key}}" style="margin:20px 60px 50px" >

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" id="exampleInputFile">
                                    <p class="help-block">Example block-level help text here.</p>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Check me out
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </div>
                        </div>

                        <form>



                        </form>

                    </div>

                </div>
            </td>
        </tr>
        @endforeach

    </tbody>
  </table>


</div>
@stop

@section('page_scripts')
<script>






</script>
@stop
