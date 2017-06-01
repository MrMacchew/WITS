<?php

namespace App\Http\Controllers\Api\v1;

use App\Room;
use Illuminate\Http\Request;
use Validator;


class RoomController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = !empty($request->query('search')) ? explode(',', $request->query('search')) : null;
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;
        $limit = $request->query('limit') ? (int) $request->query('limit') : 100;


        return Room::where('name', 'LIKE', "%$search[0]%")->with($with)->get($fields);
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
        // return ($request->all());

        $this->validate($request, [
        'name' => '',
        'number' => '',
        'building_id' => 'required'
        ]);

        $room = Room::create($request->all());
        $room->software = [];
        return $room;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request, [
        'name' => '',
        'number' => '',
        'building_id' => ''
        ]);

        $room = Room::find($room->id);
        $room->fill($request->all());

        $room->save();
        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room = Room::findOrFail($room->id);
        $room->delete();
        return $room;
    }


    public function syncDepartments(Request $request, Room $room)
    {
        // return $request->all();
        $room->departments()->detach();
        return $room->departments()->sync($request->all());
    }
}
