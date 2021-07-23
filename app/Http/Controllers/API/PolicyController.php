<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Policies;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function getList(Request $request, Policies $policies)
    {
//        dd(serialize([
//            'field2'=>'textforcheck'
//        ]));
        $arr_polices = [];
//        $policies->fetchPolicies($request->user_id);
        foreach ($policies->fetchPolicies($request->user_id) as $policy) {
            $arr_polices[] = unserialize($policy->policy_data);
        }
        return response()->json($arr_polices);
    }
}
