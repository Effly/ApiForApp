<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Policies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PolicyController extends Controller
{
    public function getList(Request $request, Policies $policies)
    {
//        dd(serialize([
//            'field2'=>'textforcheck'
//        ]));
        $arr_polices = [];
//        $policies->fetchPolicies($request->user_id);
        foreach ($policies->fetchPolicies($request->email) as $policy) {
            $arr_polices[unserialize($policy->policy_data)['number']] = [
                'last_name' => unserialize($policy->policy_data)['lastName_lat'],
                'name' => unserialize($policy->policy_data)['name_lat'],
                'date_start' => unserialize($policy->policy_data)['number'],
                'date_end' => unserialize($policy->policy_data)['number'],
            ];

//            $arr_polices['policy_number'] = unserialize($policy->policy_data)['policy_number'];
//            $arr_polices['policy_number'] = unserialize($policy->policy_data)['policy_number'];
        }
        return response()->json(['code' => 'OK', 'data_polices' => $arr_polices]);
    }

    public function obtain(Request $request, Policies $policies)
    {
        $rules = array(
            'name_lat' => 'required',
            'secondName_lat' => 'required',
            'lastName_lat' => 'required',
            'dateOfBirth' => 'required|date',
            'address' => 'string',
            'registration_date' => 'date',
            'sex' => 'required|max:1',
            'citizenship_string' => 'required',
            'series' => 'string',
            'number' => 'required',
            'issue_date' => 'required|date',
            'issue_by' => 'string',
            'duration' => 'integer',
            'email' => 'email|required'
        );
        $messages = array(
            'required' => 'Обязательно должен быть заполнен :attribute',
            'email' => 'The :attribute field is email',
            'date' => 'Поле должно быть датой',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $data = [
            'name_lat' => $request->name_lat,
            'secondName_lat' => $request->secondName_lat,
            'lastName_lat' => $request->lastName_lat,
            'dateOfBith' => $request->dateOfBith,
            'address' => $request->address,
            'registration_date' => $request->registration_date,
            'sex' => $request->sex,
            'citizenship_string' => $request->citizenship_string,
            'series' => $request->series,
            'number' => $request->number,
            'issue_date' => $request->issue_date,
            'issue_by' => $request->issue_by,
            'duration' => $request->duration,
            'email' => $request->email,
            'code_kladr' => $request->code_kladr,
        ];
        $user_email = $request->email;
        $save_policy = $policies->savePolicy($data, $user_email);

        if ($save_policy != false) return response()->json([
            'obtain_result' => ['code' => 'OK',],
            'policy_number' => $save_policy['policy_number'],
            'policy_series' => $save_policy['policy_series'],
            'ins_sum' => $save_policy['ins_sum'],
            'ins_premium' => $save_policy['ins_premium'],
            'rules_link' => $save_policy['rules_link'],
        ]);
        else return response()->json([
            'code' => 'INVALID_DATA'
        ]);

//найти реестр роскомнадзора в формат апи
    }

    public function getInfoPay(Request $request,Policies $policies)
    {
        $policies->updateStatusPay($request->policy_number);

        return response()->json(['code'=>'OK']);
    }


}
