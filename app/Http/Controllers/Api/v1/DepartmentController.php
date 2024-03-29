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
    public function index()
    {
         return \App\Helper\RestSearch::all(Department::class);
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
       $validate = $this->validate($request, [
        'name' => 'required',
        'primary_contact_name' => 'required',
        'phone' => 'nullable|size:10',
        'email' => 'nullable|email',
        'parent_department_id' => 'nullable|numeric',
        ]);

        // return $request->all();
        $department = Department::create($request->all());
        $department->org = [];

        $parent = Department::find($request->get('parent_department_id'));

        $department->parent = $parent;
        return $department;
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
        $department = Department::with(['org'])->find($department->id);

        // I commented this out because it shouldn't delete rooms if department is removed
        // foreach($department->rooms as $room)
        // {
        //     $room->delete();
        // }

        foreach($department->org as $org)
        {
            $org->delete();
        }

        $department->delete();
        return $department;

    }



}
