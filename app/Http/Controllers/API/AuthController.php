<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Codes;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'tel' => 'string'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
//        dd($request->header('Authorization'));
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
//        return response(['user' => auth()->user()]);

    }

    public function getCode(Codes $codes)
    {
        return response(['code' => $codes->getCode()]);
    }

    public function changePassword(Request $request)
    {

        $rules = array(
            'email' => 'email|required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
            'code' => 'required|min:5'
        );

        $messages = array(
            'required' => 'Обязательно должен быть заполнен :attribute',
            'email' => 'The :attribute field is email',
            'same:new_password' => 'The :attribute field must only be letters and numbers (no spaces)',
            'min:8' => 'The :attribute field must only be letters and numbers (8)',
            'min:5' => 'The :attribute field must only be letters and numbers (5)'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::where('email', $request->email)->first();
//        dd($user->last_code);
        if ((string)$user->last_code == $request->code) {
            if (Hash::check($request->new_password, $user->password) == false) {
//                dd($user->password);
                $user->password = Hash::make($request->new_password);
//                $user->password = $request->new_password;
                $user->save();
                $response['status'] = 'OK';
                $response['desc'] = 'Password reset successfully';
            } else {
                $response['status']='ERROR';
                $response['desc'] = 'It\'s old password';
            }
        } else{
            $response['status']='ERROR';
            $response['desc'] = 'INVALID_CODE';
        }

        return response()->json($response);
    }
}
