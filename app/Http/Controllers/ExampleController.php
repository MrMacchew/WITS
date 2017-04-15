<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
{

    /**
    * @SWG\Info(title="My First API", version="0.1")
    */

    /**
     * @SWG\Get(
     *     path="/api/v1/example",
     *     summary="Finds Pets by tags",
     *     tags={"Example"},
     *     description="Muliple tags can be provided with comma separated strings. Use tag1, tag2, tag3 for testing.",
     *     operationId="findPetsByTags",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         type="array",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Items(ref="#/definitions/Pet")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     ),
     *     security={
     *         {
     *             "petstore_auth": {"write:pets", "read:pets"}
     *         }
     *     },
     *     deprecated=false
     * )
     */

    public function index()
    {
        return "test";
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    *
    * @SWG\Get(
    *     path="/api/v1/example/create",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
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

    /**
    * @SWG\Post(
    *     path="/api/v1/example",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
    */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */

    /**
    * @SWG\Get(
    *     path="/api/v1/example/{id}",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
    */
    public function show(Example $example)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */

    /**
    * @SWG\Get(
    *     path="/api/v1/example/{id}/edit",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
    */

    public function edit(Example $example)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */

    /**
    * @SWG\Put(
    *     path="/api/v1/example/{id}",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
    */
    public function update(Request $request, Example $example)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Example  $example
     * @return \Illuminate\Http\Response
     */

    /**
    * @SWG\Delete(
    *     path="/api/v1/example/{id}",
    *     tags={"Example"},
    *     @SWG\Response(response="200", description="An example resource")
    * )
    */
    public function destroy(Example $example)
    {
        //
    }

    public function foo(){}
}
