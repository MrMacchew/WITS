<?php

namespace App\Http\Controllers\Api\v1;

use App\Campus;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laravel\Passport\HasApiTokens;


class CampusController extends ApiController
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
     *     tags={"Campus"},
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
        return \App\Helper\RestSearch::all(Campus::class);
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
        $campus = Campus::create($request->all());
        return Campus::with('buildings', 'buildings.rooms')->find($campus->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $with = !empty($request->query('with')) ? explode(',', $request->query('with')) : [];
        $fields = !empty($request->query('fields')) ? explode(',',$request->query('fields')) : null;

        return Campus::with($with)->find($id, $fields);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(Campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campus $campus)
    {
        // $this->validate($request, [
        // 'name' => 'unique:campus',
        // 'campus_code' => 'unique:campus',
        // ]);

        $campus = Campus::find($campus->id);
        $campus->fill($request->all());

        $campus->save();
        return $campus;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campus $campus)
    {
        $campus = Campus::with(['buildings', 'buildings.rooms'])->find($campus->id);

        // return $campus;
        foreach($campus->buildings as $building)
        {
            foreach($building->rooms as $room)
            {
                $room->delete();
            }
            $building->delete();
        }



        $campus->delete();
        return $campus;

    }

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
