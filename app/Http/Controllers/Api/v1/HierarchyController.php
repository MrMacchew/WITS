<?php

namespace App\Http\Controllers\Api\v1;

use App\Hierarchy;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Passport\HasApiTokens;


class HierarchyController extends ApiController
{

    use HasApiTokens, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/api/v1/campus",
     *     summary="get all campuses",
     *     tags={"Hierarchy"},
     *     description="Muliple tags can be provided with comma separated strings. Use tag1, tag2, tag3 for testing.",
     *     operationId="findPetsByTags",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Items(ref="#/definitions/Pet")
     *         ),
     *     ),
     *     deprecated=false
     * )
     */
    public function index(Request $request)
    {
        // $search = !empty($request->query('search')) ? explode(',', $request->query('search')) : null;
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;
        // $limit = $request->query('limit') ? (int) $request->query('limit') : 100;

        // return Hierarchy::all()->groupBy('division_id');
        // return Hierarchy::all()->groupBy('department_id');
        // return Hierarchy::all()->groupBy('team_id');
        return Hierarchy::with($with)->get($fields);
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
       $this->validate($request, [
        'name' => 'required|unique:campus',
        'campus_code' => 'required|unique:campus',
        ]);
        $hierarchy = Hierarchy::create($request->all());
        return Hierarchy::with('buildings', 'buildings.rooms')->find($hierarchy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hierarchy  $hierarchy
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return Hierarchy::with($with)->find($id, $fields);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hierarchy  $hierarchy
     * @return \Illuminate\Http\Response
     */
    public function edit(Hierarchy $hierarchy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hierarchy  $hierarchy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hierarchy $hierarchy)
    {
        // $this->validate($request, [
        // 'name' => 'unique:campus',
        // 'campus_code' => 'unique:campus',
        // ]);

        $hierarchy = Hierarchy::find($hierarchy->id);
        $hierarchy->fill($request->all());

        $hierarchy->save();
        return $hierarchy;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hierarchy  $hierarchy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hierarchy $hierarchy)
    {
        $hierarchy = Hierarchy::with(['buildings', 'buildings.rooms'])->find($hierarchy->id);

        // return $hierarchy;
        foreach($hierarchy->buildings as $building)
        {
            foreach($building->rooms as $room)
            {
                $room->delete();
            }
            $building->delete();
        }



        $hierarchy->delete();
        return $hierarchy;

    }

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
