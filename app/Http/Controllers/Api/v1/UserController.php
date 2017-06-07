<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //search usage - api/v1/users?search=de
        //relations usage - api/v1/users?with=roles,departments
        //fields usage - api/v1/users?fields=email,id,username
        //all usages - api/v1/users?search=de&fields=email,id,username&with=roles,departments

        //search
        //with - get relations
        //fields

        $search = !empty($request->query('search')) ? explode(',', $request->query('search')) : null;
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;
        $limit = $request->query('limit') ? (int) $request->query('limit') : 100;


        // dump("search", $search);
        // dump("with", $with);
        // dump("fields", $fields);
        // dump("limit", $limit );


        // return User::where('email', 'LIKE', "%$search[0]%")->with($with)->paginate($limit, $fields);
        return User::where('email', 'LIKE', "%$search[0]%")->with($with)->get($fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return User::with($with)->find($id, $fields);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function syncDepartments(Request $request, User $user)
    {
        $data = collect($request->all());
        // return $request->all();
        $ids = $user->departments()->sync($data->pluck('id'));
        $departments['attached'] = \App\Department::find($ids["attached"]);
        $departments['detached'] = \App\Department::find($ids["detached"]);
        $departments['updated'] = \App\Department::find($ids["updated"]);
        return $departments;
    }

    public function syncRoles(Request $request, User $user)
    {
        $data = collect($request->all());
        // return $data->pluck('name');
        $ids = $user->syncRoles($data->pluck('name'));

        return $user->roles()->pluck('name');
    }
}
