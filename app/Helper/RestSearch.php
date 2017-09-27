<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
*
*/
class RestSearch
{
        //search usage - api/v1/users?search=de
        //with usage - api/v1/users?with=model1,model2
        //search columns usage - api/v1/asset?searchColumns=name,model,manufacturer&search=lap
        //fields usage - api/v1/users?fields=email,id,username
        //all usages - api/v1/users?search=de&fields=email,id,username&with=model1,model2

        public static function get($model)
        {
            $search = !empty(request()->query('search')) ? explode(',', request()->query('search')) : null;
            $searchColumns = !empty(request()->query('searchColumns')) ? explode(',', request()->query('searchColumns')) : [];
            $with = !empty(request()->query('with')) ? explode(',', request()->query('with')) : [];
            $fields = !empty(request()->query('fields')) ? explode(',',request()->query('fields')) : null;

            // dump($search);
            // dump($searchColumns);
            // dump($with);
            // dump($fields);
            // dump($limit);

            return $model::orWhere(function ($query) use ($searchColumns, $search) {
                // dump($searchColumns, $search);
                foreach ($searchColumns as $key => $value) {
                    // dump($key, $value);
                    $query->orWhere($value, 'LIKE', "%$search[0]%");
                }

            })
            ->with($with)
            ->get($fields)
            ;
        }

}
