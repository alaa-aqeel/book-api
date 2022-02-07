<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Find object by Id 
     * 
     * @param object $model 
     * @param int $id 
     * @return object|abort(404)
     */
    public function findOrfailObject($model, $id) 
    {
        if($obj = $model::find($id)) {
            return $obj;
        }

        abort(response()->json([
            "message" => __("messages.errors.notfound")
        ], 404));
    }
}
