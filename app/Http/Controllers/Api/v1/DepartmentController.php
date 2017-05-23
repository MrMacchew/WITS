<?php

namespace App\Http\Controllers\Api\v1;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Passport\HasApiTokens;


class DepartmentController extends ApiController
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
     *     tags={"Department"},
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
        $search = !empty($request->query('search')) ? explode(',', $request->query('search')) : null;
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;
        $limit = $request->query('limit') ? (int) $request->query('limit') : 100;

        $hierarchy = Department::where('name', 'LIKE', "%$search[0]%")->with($with)->get($fields);
        $hierarchy->groupBy('name');


        $hierarchy = collect((Object) [
            "divisions" => $hierarchy,
            "departments" => $hierarchy,
            "teams" => $hierarchy,
            ]);


        return $hierarchy;

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
        $department = Department::create($request->all());
        return Department::with('buildings', 'buildings.rooms')->find($department->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return Department::with($with)->find($id, $fields);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        // $this->validate($request, [
        // 'name' => 'unique:campus',
        // 'campus_code' => 'unique:campus',
        // ]);

        $department = Department::find($department->id);
        $department->fill($request->all());

        $department->save();
        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department = Department::with(['buildings', 'buildings.rooms'])->find($department->id);

        // return $department;
        foreach($department->buildings as $building)
        {
            foreach($building->rooms as $room)
            {
                $room->delete();
            }

            $building->delete();
        }



        $department->delete();
        return $department;

    }

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function hierarchy($item = 'test')
    {
        return "testing the link " . $item;
    }
}
