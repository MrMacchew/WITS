<?php

namespace App\Http\Controllers\Api\v1;

use App\Building;
use Illuminate\Http\Request;

class BuildingController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Helper\RestSearch::get(Building::class);
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
        // $this->validate($request, [
        // 'name' => 'required|unique:building',
        // ]);

        $building = Building::create($request->all());
        $building->rooms = [];
        return $building;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return Building::with($with)->find($id, $fields);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {

        $this->validate($request, [
        // 'name' => 'unique:building',
        ]);

        $building = Building::find($building->id);
        $building->fill($request->all());

        $building->save();
        return $building;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy(Building $building)
    {
        $building = Building::with(['rooms'])->find($building->id);
        // return $building;

        foreach($building->rooms as $room)
        {
            $room->delete();
        }
        $building->delete();
        return $building;
    }
}
