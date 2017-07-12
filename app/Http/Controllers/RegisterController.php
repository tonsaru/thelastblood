<?php

namespace App\Http\Controllers;

use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function signUp(Request $request, JWTAuth $JWTAuth)
    {
        $validator = Validator::make($request->all(),
                        Config::get('boilerplate.sign_up.validation_rules'),
                        Config::get('boilerplate.sign_up.message'));

       if ($validator->fails()) {
        //    return $validator->errors()->toArray();
            return $validator->messages();
            // return $validator->errors()->all();
       }
        // $user = new User($request->all());
        $user = new User;
        $user->name = strtolower($request->name);
        $user->password = strtolower($request->password);
        $user->blood = strtolower($request->blood);
        $user->blood_type = strtolower($request->blood_type);
        $user->blood = strtolower($request->blood);
        $user->blood_type = strtolower($request->blood_type);
        $user->email = $request->email;
        $user->birthyear = $request->birthyear;
        $user->province = $request->province;
        $user->save();
        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'ok'
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'status' => 'ok',
            'token' => $token
        ], 201);
    }

    //Check Register
      public function check(Request $request){
          $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:191|Alpha|unique:users',
              'email' => 'required|string|email|max:191|unique:users',
              'phone' => 'required|string|max:10|unique:users',
         ]);
         if ($validator->fails()) {
          //    return $validator->errors()->toArray();
              return $validator->messages();
              // return $validator->errors()->all();
         }
      }

      public function pim(Request $request){
        //   $a = "array("121212123","12121212","1213131312")";
        //   $digits = substr($a, strpos($a, '(')+2 , strlen($a)-9);
        // $splitName = explode(' ', $name);
        //
        // $data = array($request->data);
        return $request->data;
      }
}
